<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use ApiPlatform\Core\Bridge\Symfony\Routing\Router;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Bridge\Doctrine\Transport\DoctrineTransport;
use Symfony\Contracts\Service\ServiceProviderInterface;

class BooksTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    private Client $client;
    private Router $router;

    protected function setup(): void
    {
        $this->client = static::createClient();
        $router = static::$container->get('api_platform.router');
        if (!$router instanceof Router) {
            throw new \RuntimeException('api_platform.router service not found.');
        }
        $this->router = $router;
    }

    public function testGetCollection(): void
    {
        // The client implements Symfony HttpClient's `HttpClientInterface`, and the response `ResponseInterface`
        $response = $this->client->request('GET', '/books');
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/contexts/Book',
            '@id' => '/books',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 100,
            'hydra:view' => [
                '@id' => '/books?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/books?page=1',
                'hydra:last' => '/books?page=4',
                'hydra:next' => '/books?page=2',
            ],
        ]);

        // It works because the API returns test fixtures loaded by Alice
        self::assertCount(30, $response->toArray()['hydra:member']);

        static::assertMatchesJsonSchema(file_get_contents(__DIR__.'/schemas/books.json'));
        // Checks that the returned JSON is validated by the JSON Schema generated for this API Resource by API Platform
        // This JSON Schema is also used in the generated OpenAPI spec
        self::assertMatchesResourceCollectionJsonSchema(Book::class);
    }

    public function testCreateBook(): void
    {
        $response = $this->client->request('POST', '/books', ['json' => [
            'isbn' => '0099740915',
            'title' => 'The Handmaid\'s Tale',
            'description' => 'Brilliantly conceived and executed, this powerful evocation of twenty-first century America gives full rein to Margaret Atwood\'s devastating irony, wit and astute perception.',
            'author' => 'Margaret Atwood',
            'publicationDate' => '1985-07-31T00:00:00+00:00',
        ]]);

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/contexts/Book',
            '@type' => 'http://schema.org/Book',
            'isbn' => '0099740915',
            'title' => 'The Handmaid\'s Tale',
            'description' => 'Brilliantly conceived and executed, this powerful evocation of twenty-first century America gives full rein to Margaret Atwood\'s devastating irony, wit and astute perception.',
            'author' => 'Margaret Atwood',
            'publicationDate' => '1985-07-31T00:00:00+00:00',
            'reviews' => [],
        ]);
        self::assertMatchesRegularExpression('~^/books/[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}$~', $response->toArray()['@id']);
        self::assertMatchesResourceItemJsonSchema(Book::class);
    }

    public function testCreateInvalidBook(): void
    {
        $this->client->request('POST', '/books', ['json' => [
            'isbn' => 'invalid',
        ]]);

        self::assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        self::assertJsonContains([
            '@context' => '/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'isbn: This value is neither a valid ISBN-10 nor a valid ISBN-13.
title: This value should not be blank.
description: This value should not be blank.
author: This value should not be blank.
publicationDate: This value should not be null.',
        ]);
    }

    public function testUpdateBook(): void
    {
        $iri = (string) $this->findIriBy(Book::class, ['isbn' => '9786644879585']);
        $this->client->request('PUT', $iri, ['json' => [
            'title' => 'updated title',
        ]]);

        self::assertResponseIsSuccessful();
        self::assertJsonContains([
            '@id' => $iri,
            'isbn' => '9786644879585',
            'title' => 'updated title',
        ]);
    }

    public function testDeleteBook(): void
    {
        $token = $this->login();
        $client = static::createClient();
        $iri = (string) $this->findIriBy(Book::class, ['isbn' => '9786644879585']);
        $client->request('DELETE', $iri, ['auth_bearer' => $token]);

        self::assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
        self::assertNull(
            // Through the container, you can access all your services from the tests, including the ORM, the mailer, remote API clients...
            static::$container->get('doctrine')->getRepository(Book::class)->findOneBy(['isbn' => '9786644879585'])
        );
    }

    public function testGenerateCover(): void
    {
        $book = static::$container->get('doctrine')->getRepository(Book::class)->findOneBy(['isbn' => '9786644879585']);
        self::assertInstanceOf(Book::class, $book);
        if (!$book instanceof Book) {
            throw new \LogicException('Book not found.');
        }
        $this->client->request('PUT', $this->router->generate('api_books_generate_cover_item', ['id' => $book->getId()]), [
            'json' => [],
        ]);

        $messengerReceiverLocator = static::$container->get('messenger.receiver_locator');
        if (!$messengerReceiverLocator instanceof ServiceProviderInterface) {
            throw new \RuntimeException('messenger.receiver_locator service not found.');
        }
        $doctrine = $messengerReceiverLocator->get('doctrine');

        // Stan (+Symfony plugin) tries to resolve the doctrine service, but it is
        // wrong as it takes the global container and not the messenger receiver locator.
        if (!$doctrine instanceof DoctrineTransport) { /* @phpstan-ignore-line */
            throw new \RuntimeException('doctrine transport service not found.');
        }

        /* @phpstan-ignore-next-line */ // Because of previous phpstan-ignore-line
        self::assertResponseIsSuccessful();
        self::assertEquals(
            1,
            $doctrine->getMessageCount(),
            'No message has been sent.'
        );
    }

    private function login(): string
    {
        $response = static::createClient()->request('POST', '/authentication_token', ['json' => [
            'email' => 'admin@example.com',
            'password' => 'admin',
        ]]);

        return $response->toArray()['token'];
    }
}

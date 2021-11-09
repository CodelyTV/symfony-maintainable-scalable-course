<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\DataProvider\TopBookCollectionDataProvider;
use App\Entity\TopBook;
use Symfony\Component\HttpFoundation\Response;

/**
 * These tests are read only, thus there is not need to use the RefreshDatabaseTrait
 * like BooksTests and ReviewsTest.
 */
class TopBooksTest extends ApiTestCase
{
    private Client $client;
    private const PAGINATION_ITEMS_PER_PAGE = 10;

    protected function setup(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @see TopBookCollectionDataProvider::getCollection()
     */
    public function testGetCollection(): void
    {
        $response = $this->client->request('GET', '/top_books');
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonContains([
            '@context' => '/contexts/TopBook',
            '@id' => '/top_books',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 100,
            'hydra:view' => [
                '@id' => '/top_books?page=1',
                '@type' => 'hydra:PartialCollectionView',
                'hydra:first' => '/top_books?page=1',
                'hydra:last' => '/top_books?page=10',
                'hydra:next' => '/top_books?page=2',
            ],
        ]);

        // 10 is the "pagination_items_per_page" parameters configured in the TopBook ApiResource annotation.
        self::assertCount(self::PAGINATION_ITEMS_PER_PAGE, $response->toArray()['hydra:member']);

        // Checks that the returned JSON is validated by the JSON Schema generated for this API Resource by API Platform
        // This JSON Schema is also used in the generated OpenAPI spec
        self::assertMatchesResourceCollectionJsonSchema(TopBook::class);

        // This 2nd call use the cache @see TopBookCachedDataRepository
        $response = $this->client->request('GET', '/top_books');
        self::assertResponseIsSuccessful();
        self::assertCount(self::PAGINATION_ITEMS_PER_PAGE, $response->toArray()['hydra:member']);
    }

    /**
     * Nominal case.
     *
     * @see TopBookItemDataProvider::getItem()
     */
    public function testGetItem(): void
    {
        $this->client->request('GET', '/top_books/1');
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertJsonEquals([
            '@context' => '/contexts/TopBook',
            '@id' => '/top_books/1',
            '@type' => 'TopBook',
            'id' => 1,
            'title' => "Depuis l'au-delà",
            'author' => 'Werber Bernard',
            'part' => '',
            'place' => 'F WER',
            'borrowCount' => 9,
        ]);

        self::assertMatchesResourceItemJsonSchema(TopBook::class);
    }

    /**
     * Error case n°1: invalid identifier.
     *
     * @see TopBookItemDataProvider::checkId()
     */
    public function testGetItemErrorIdIsNotAnInteger(): void
    {
        $this->client->request('GET', '/top_books/foo');
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * Error case n°2: out of range identifier.
     *
     * @see TopBookItemDataProvider::checkId()
     */
    public function testGetItemErrorIdIsOutOfRange(): void
    {
        $this->client->request('GET', '/top_books/101');
        self::assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SwaggerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setup(): void
    {
        $this->client = static::createClient();
    }

    public function testStats(): void
    {
        $this->client->request('GET', '/docs.json');
        self::assertResponseIsSuccessful();
        self::assertStringContainsString('/stats', (string) $this->client->getResponse()->getContent());
    }
}

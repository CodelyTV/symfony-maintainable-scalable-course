<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use Symfony\Component\Panther\PantherTestCase;

class HomeTest extends PantherTestCase
{
    public function testHome(): void
    {
        $client = static::createPantherClient();
        $client->request('GET', '/');

        $this->assertSelectorTextContains('h1', 'Welcome to');
        //$this->assertSelectorTextContains('h1', 'Codely');
    }
}
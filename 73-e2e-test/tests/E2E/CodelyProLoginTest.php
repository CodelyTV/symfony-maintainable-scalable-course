<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use Symfony\Component\Panther\PantherTestCase;

class CodelyProLoginTest extends PantherTestCase
{
    /** @test */
    public function itShouldLoginToCodelyPro(): void
    {
        $client = static::createPantherClient();
        $client->request('GET', 'https://codely.tv');
        $client->manage()->window()->maximize();

        $client->clickLink('Inicia sesión');
        $crawler = $client->waitFor('.Auth');

        $crawler->selectButton('Sign in')->form([
            'username' => $this->getContainer()->getParameter('codely_user'),
            'password' => $this->getContainer()->getParameter('codely_password')
        ]);

        $crawler->selectButton('Sign in')->click();
        $client->waitFor('h1');

        $this->assertSelectorTextContains('h1', 'Dani');
    }
}
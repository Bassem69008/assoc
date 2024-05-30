<?php

namespace App\Tests\e2e;

use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;

class UserTest extends PantherTestCase
{
    public function testUserCanRegister(): void
    {
        // putenv('PANTHER_CHROME_DRIVER_BINARY=/snap/bin/chromium');
        // $client = static::createPantherClient();
        // $client = Client::createChromeClient();
        $client = static::createPantherClient();

        // Go to the registration page
        $crawler = $client->request('GET', '/register');

        // Fill in the form and submit it
        $form = $crawler->selectButton('Enregistrer')->form([
            'user[firstName]' => 'John',
            'user[lastName]' => 'Doe',
            'user[email]' => 'john.doe@example.com',
            'user[roles]' => 'ROLE_ADMIN',
            'user[isVerified]' => true,
        ]);

        $client->submit($form);

        // Assert the user was redirected to the login page
        $this->assertPageTitleContains('Login');
        $this->assertSelectorTextContains('h1', 'Login');
    }
}

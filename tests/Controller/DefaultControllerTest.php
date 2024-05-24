<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Functional tests to test all the public and secure
 * URLs of the application.
 *
 * @internal
 *
 * @coversNothing
 */
final class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider getSecureUrls
     */
    public function testSecureUrls(string $url): void
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertResponseRedirects(
            'http://localhost/login',
            Response::HTTP_FOUND,
            sprintf('The %s secure URL redirects to the login form.', $url)
        );
    }

    public function getSecureUrls(): \Generator
    {
        yield ['/admin/'];
    }
}

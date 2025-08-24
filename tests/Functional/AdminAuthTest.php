<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminAuthTest extends WebTestCase
{
    // test pas de connexion, pas d'accès à /admin
    public function testAdminRequiresLogin(): void
    {
        $client = static::createClient();
        $client = $client->request('GET', '/admin');
        self::assertResponseRedirects('/login');

    }

    // test connexion avec les bons identifiants
    public function testLoginSuccessToAdmin(): void
    {
        $client = static::createClient();
        // Ouvre la page login
        $crawler = $client->request('GET', '/login');
        self::assertResponseIsSuccessful();

        // Soumission du formulaire
        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'admin1@fccn.com',
            'password' => 'Azerty77',
        ]);
        $client->submit($form);

        // Redirection vers /admin
        self::assertResponseRedirects('/admin');
        $client->followRedirect();
    }

    // test connexion mauvais password
    public function testLoginFailedBadPassword(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        self::assertResponseIsSuccessful();

        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'admin1@fccn.com',
            'password' => '123456789', // bad password
        ]);
        $client->submit($form);

        // redirection vers login
        self::assertResponseRedirects('/login');
        $client->followRedirect();

        self::assertSelectorExists('[data-test="login-error"]');
    }

    // test connexion email inconnu
    public function testLoginFailedUnknownEmail(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        self::assertResponseIsSuccessful();

        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'test@test.com', // unknown email
            'password' => 'Azerty77',
        ]);
        $client->submit($form);

        // redirection vers /login
        self::assertResponseRedirects('/login');
        $client->followRedirect();

        // message d'erreur
        self::assertSelectorExists('[data-test="login-error"]');
    }

}

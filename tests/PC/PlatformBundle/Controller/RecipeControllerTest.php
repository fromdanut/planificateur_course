<?php

namespace Tests\PC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    /**
      * Test simplement que le login retourne un code http 200.
      */
    public function testLoginIsUp()
    {
        // Create a client.
        $client = static::createClient();
        // Request the homepage
        $client->request('GET', '/login');
        // Get the status code of the response
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    /**
      * Test la création d'un compte.
      */
    public function testAddUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        // Récupère le form grace au crawler.
        $form = $crawler->selectButton('Créer un compte')->form();
        // On rempli manuellement le form (en reprenant le "name" de l'input).
        $form['fos_user_registration_form[email]'] = 'user@mail.com';
        $form['fos_user_registration_form[username]'] = 'user';
        $form['fos_user_registration_form[plainPassword][first]'] = 'user';
        $form['fos_user_registration_form[plainPassword][second]'] = 'user';

        // Soumettre le formulaire et suivre la redirection.
        $client->submit($form);
        $client->followRedirect();
        $this->assertSame(302, $client->getResponse()->getStatusCode());

        // Suivre la redirection après création du compte.
        $crawler = $client->followRedirect();

        // Vérifie qu'on a bien le message de création de compte.
        $this->assertSame(1, $crawler->filter('html:contains("utilisateur a été créé avec succès")')->count());

        // Supprime le compte créé : important sinon le test ne passe qu'une fois,
        // après quoi la création de compte est rendu impossible car on a déjà
        // une entré pour le nom d'uitlisateur.
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('UserBundle:User')->findOneBy(array('username' => 'user'));
        $em->remove($user);
        $em->flush();
    }

    /**
      * Test le login avec user minus et mdp minus, puis logout.
      */
    public function testLoginLogout()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        // Récupère le form grace au crawler.
        $form = $crawler->selectButton('Connexion')->form();
        // On rempli manuellement le form (en reprenant le "name" de l'input).
        $form['_username'] = 'minus';
        $form['_password'] = 'minus';

        // Soumettre le formulaire et suivre la redirection.
        $client->submit($form);
        $client->followRedirect();
        $this->assertSame(302, $client->getResponse()->getStatusCode());

        // Le routeur execute une seconde redirection vers "/home"
        $crawler = $client->followRedirect();
        // Vérifie qu'on a bien le message de bienvenu dans un balise h1.
        $this->assertSame(1, $crawler->filter('h1:contains("Content de vous revoir minus")')->count());

        // Log out
        $link = $crawler->selectLink('Déconnexion')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('p:contains("Ce site permet de gérer un livre de recettes")')->count());
    }


}

 ?>

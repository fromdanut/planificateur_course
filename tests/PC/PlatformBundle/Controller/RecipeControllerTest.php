<?php

namespace Tests\PC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
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
    public function testLoginAddUser()
    {
        $client = static::createClient(array(), array('HTTP_HOST' => 'localhost:8000'));
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
        $this->assertTrue($client->getResponse()->isRedirect());

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
}

 ?>

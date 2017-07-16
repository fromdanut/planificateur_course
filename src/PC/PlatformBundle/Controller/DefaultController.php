<?php

namespace PC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if ($this->getUser() === null) { # s'il l'utilisateur n'est pas authentifié.
            return $this->redirectToRoute('pc_platform_login');
        }
        else {
            return $this->redirectToRoute('pc_platform_homepage');
        }
    }

    public function homeAction()
    {
        return $this->render('PCPlatformBundle:Default:home.html.twig');
    }

    public function loginAction()
    {
        return $this->render('PCPlatformBundle::login.html.twig');
    }


}

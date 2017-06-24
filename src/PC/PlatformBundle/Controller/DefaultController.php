<?php

namespace PC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PCPlatformBundle:Default:index.html.twig');
    }

    public function redirectToIndexAction()
    {
        return $this->redirectToRoute('pc_platform_homepage');
    }
}

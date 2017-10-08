<?php
// src/PC/PlatformBundle/Moderation/PCModreation.php

namespace PC\PlatformBundle\Moderation;

use PC\PlatformBundle\Entity\Recipe;

/**
 * Service to moderate the recipe with a single method (moderate) for now.
 */
class PCModeration
{
    protected $mailer;
    protected $templating;
    protected $router;
    protected $sha1ed_secret;
    protected $mailer_user;
    protected $mail_admin;

    public function __construct(\Swift_Mailer $mailer,
                                $templating,
                                $router,
                                $secret,
                                $mailer_user,
                                $mail_admin)
    {
      $this->mailer = $mailer;
      $this->templating = $templating;
      $this->router = $router;
      $this->sha1ed_secret = sha1($secret);
      $this->mailer_user = $mailer_user;
      $this->mail_admin = $mail_admin;
    }

    /**
     * Send a mail to admin who receive a mail in which he has the option to:
     * validate or delete the recipe (action via url).
     *
     * @param Recipe $recipe
     * @return bool
     */
    public function moderate(Recipe $recipe)
    {
        // Generate the url that will be sent to admin to valid the recipe
        $url_valide = $this->router->generate("pc_platform_moderate_recipe", array(
            'sha'    => $this->sha1ed_secret,
            'action' => 'valide',
            'id'     => $recipe->getId(),
        ));

        $url_delete = $this->router->generate("pc_platform_moderate_recipe", array(
            'sha'    => $this->sha1ed_secret,
            'action' => 'delete',
            'id'     => $recipe->getId(),
        ));

        // Send a mail to the admin
        $message = \Swift_Message::newInstance()
            ->setFrom($this->mailer_user)
            ->setTo($this->mail_admin)
            ->setSubject('new recipe in planificateur')
            ->setBody(
                $this->templating->render(
                    'PCPlatformBundle:Recipe:email.txt.twig',
                    array(
                        'recipe'        => $recipe,
                        'url_valide'    => $url_valide,
                        'url_delete'    => $url_delete,
                    )
                )
            );

        $this->mailer->send($message);
        return true;
    }

}

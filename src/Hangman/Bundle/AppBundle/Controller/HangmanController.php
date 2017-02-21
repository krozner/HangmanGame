<?php

namespace Hangman\Bundle\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HangmanController extends Controller
{
    /**
     * @Route("/scripts.js", name="hangman_scripts")
     */
    public function scriptsAction()
    {
        $response = $this->render('@resources/scripts/scripts.js.twig');
        $response
            ->headers->set('Content-Type', 'application/javascript');

        return $response;
    }

    /**
     * @Route("/", name="hangman_homepage")
     */
    public function homepageAction()
    {
        return $this->render('@resources/views/hangman.html.twig', [
            'categories' => $this->getDoctrine()
                ->getRepository("HangmanAppBundle:Category")
                ->fetchAvailable(),
            'alphabet' => range('A', 'Z')
        ]);
    }

}

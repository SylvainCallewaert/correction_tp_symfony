<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('app/homepage.html.twig', []);
    }
}

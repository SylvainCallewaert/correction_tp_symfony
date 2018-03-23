<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Utilisateur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    /**
     * @Route("/", name="service_route")
     */
    public function serviceAction(Request $request)
    {
        /* utilisation d'une classe normal sans service */
        /*
        $util = new Util();
        $num = $util->generateNumCommande();
        */

        $util = $this->get('app.util');
        $num = $util->generateNumCommande();

        return new Response($num);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class EspacePersoController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard_espaceperso")
     */
    public function dashboardAction(Request $request)
    {
            return $this->render('espace-perso/dashboard.html.twig');
    }

    /**
     * @Route("/mon-profil", name="profil_espaceperso")
     */
    public function profilAction(Request $request)
    {
        return $this->render('espace-perso/profil.html.twig');
    }

    /**
     * @Route("/pro", name="pro_espaceperso")
     */
    public function proAction(Request $request)
    {
        /* soit ça dans le controller, soit dans le fichier security */
        /*
        if (! $this->isGranted('ROLE_PRO')) {
            throw new AccessDeniedException();
        }
        */

        return $this->render('espace-perso/pro.html.twig');
    }

    /**
     * @Route("/login", name="login_espaceperso")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('espace-perso/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/login_check", name="login_check_espaceperso")
     */
    public function loginCheckAction(Request $request)
    {

    }

    /**
     * @Route("/logout", name="logout_espaceperso")
     */
    public function logoutAction(Request $request)
    {

    }
}

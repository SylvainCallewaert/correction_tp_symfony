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

class AdminController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction(Request $request)
    {
            return $this->render('admin/dashboard.html.twig');
    }

    /**
     * @Route("/utilisateurs", name="admin_utilisateurs")
     */
    public function utilisateursAction(Request $request)
    {
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException();
        }

        return $this->render('admin/utilisateurs.html.twig');
    }


    /**
     * @Route("/login", name="login_admin")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login_admin.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/login_check", name="login_check_admin")
     */
    public function loginCheckAction(Request $request)
    {

    }

    /**
     * @Route("/logout", name="logout_admin")
     */
    public function logoutAction(Request $request)
    {

    }


    /* EXERCICE */
    /*
     *
     * Créer dans votre application des routes sécurisées
     * Commençant par /espace-perso/
     * Grâce à un controller EspacePersoController
     * Garder un firewall qui attrape toutes les autres routes
     * et y autorise les connexions anonyme
     * Il faut alors un formulaire de connexion et les routes
     * nécessaires
     * Utiliser des utilisateurs in_memory
     * créer un role user qui a le droit de voir toutes les pages
     * de l'espace perso sauf une page de cet espace
     * réservé à des PRO
     * Créer le role correspons user pro et lui permettre
     * d'accéder à cette page
     * le lien vers la page pro doit être affiché sur l'espace perso
     * uniquement pour les profils
     *
     *
     *
     */

}

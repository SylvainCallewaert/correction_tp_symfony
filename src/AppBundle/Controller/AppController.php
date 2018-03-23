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

class AppController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        $session = $request->getSession();

        // vérifier que le panier existe en session, sinon le créer
        if (!$session->has('panier')) {
            $session->set('panier', []);
        }

        $panier =  $session->get('panier');

        $nbArticles = 0;
        foreach ($panier as $key => $article) {
            $nbArticles += $article;
        }

        return $this->render('app/homepage.html.twig', [
            'articles' => $articles,
            'nbArticles' => $nbArticles
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_display")
     */
    public function articleDisplayAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        return $this->render('app/display.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     */
    public function articleDeleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if ($article instanceof Article) {
            $em->remove($article);
            $em->flush();
            $this->addFlash('success', 'Article supprimé');
        }
        else {
            $this->addFlash('danger', 'Article non trouvé');
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/insert/article", name="article_insert")
     */
    public function articleInsertAction(Request $request)
    {
        $article = new Article();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $article);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('nom', null, ['label' => 'Titre de l\'article'])
            ->add('description', null, ['attr' => ['placeholder' => 'description de l\'article']])
            ->add('stock')
            ->add('prix')
            ->add('valider', SubmitType::class)
        ;
        // on récupérer l'objet form
        $form = $formBuilder->getForm();

        // handle request qui appelle automatiquement les seeter de l'objet article
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // On enregistre notre objet $article dans la base de données, par exemple
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                $this->addFlash('success', "L'article a bien été via un formulaire.");

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('app/insert_article.html.twig', ['formArticle' => $form->createView()]);
    }

    /**
     * @Route("/insert/user", name="user_insert")
     */
    public function userInsertAction(Request $request)
    {
        $user = new Utilisateur();
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('email', EmailType::class)
            ->add('nom')
            ->add('prenom')
            ->add('codePostal')
            ->add('telephone')
            ->add('username')
            ->add('password', PasswordType::class)
            ->add('valider', SubmitType::class)
        ;

        // on récupérer l'objet form
        $form = $formBuilder->getForm();

        // handle request qui appelle automatiquement les seeter de l'objet article
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // On enregistre notre objet $user dans la base de données, par exemple
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', "L'utilisateur a bien été créé via un formulaire.");

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('app/insert_user.html.twig', ['formUser' => $form->createView()]);
    }

    /**
     * @Route("/commande", name="commande")
     */
    public function commandeAction(Request $request)
    {
        $session = $request->getSession();

        // vérifier que le panier existe en session, sinon le créer
        if (!$session->has('panier')) {
            $session->set('panier', []);
        }

        $panier = $session->get('panier');

        $em = $this->getDoctrine()->getManager();

        $panierDetails = [];
        foreach ($panier as $key => $value) {
            $article = $em->getRepository('AppBundle:Article')->find($key);

            if ($article != null) {
                $panierDetails[] = [$article, $value];
            }
            else {
                $this->addFlash('danger', 'Un des articles sélectionnés n\'existe plus.');
            }
        }

        return $this->render('app/commande.html.twig', ['panier' => $panierDetails]);
    }

    /**
     * @Route("/ajout-article-panier/{idArticle}", name="ajout_article_panier")
     */
    public function ajoutArticlePanierAction(Request $request, $idArticle)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($idArticle);

        if ($article == null) {
            $this->addFlash('danger', "Article non trouvé.");
            return $this->redirectToRoute('homepage');
        }

        $session = $request->getSession();

        // vérifier que le panier existe en session, sinon le créer
        if (!$session->has('panier')) {
            $session->set('panier', []);
        }

        // récupérer le panier en session
        $panier = $session->get('panier');

        // vérifier si l'article a déjà été ajouté, et si oui incrémenter la quantité de 1
        if (array_key_exists($idArticle, $panier)) {
            $panier[$idArticle] += 1;
        }
        // sinon initialiser ce produit avec 1
        else {
            $panier[$idArticle] = 1;
        }

        // remettre la bonne valeur en session
        $session->set('panier', $panier);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/valider-commande", name="valider_commande")
     */
    public function validerCommandeAction(Request $request)
    {
        $session = $request->getSession();

        // vérifier que le panier existe en session, sinon le créer
        if (!$session->has('panier') || count($session->get('panier')) == 0) {
            $this->addFlash('danger', 'Aucun article dans le panier.');
            return $this->redirectToRoute('homepage');
        }

        $em = $this->getDoctrine()->getManager();

        $commande = new Commande();
        $commande->setNumero(date('Ymd').rand(1, 5000));

        $panier = $session->get('panier');
        foreach ($panier as $key => $value) {
            $article = $em->getRepository('AppBundle:Article')->find($key);

            if ($article != null) {
                $commande->addArticle($article);

            }
            else {
                $this->addFlash('danger', 'Impossible de passer la commande, un article n\'est plus dispo');
                return $this->redirectToRoute('homepage');
            }
        }

        $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();
        if (count($utilisateurs) > 0) {
            $utilisateur = $utilisateurs[0];
            $commande->setUtilisateur($utilisateur);
        }

        $em->persist($commande);
        $em->flush();

        $this->addFlash('success', 'Commande validée.');
        return $this->redirectToRoute('homepage');
    }
}

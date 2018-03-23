<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Article;
use AppBundle\Entity\Commande;
use AppBundle\Util\Util;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * EntitiesListener
 */
class EntitiesListener
{
    private $utils;

    public function __construct($utils=null) {
        $this->utils = $utils;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        /*
        if (method_exists ($entity, 'setCreatedAt')) {
            if ($entity->getCreatedAt() == null) {
                $now = new \DateTime();
                $entity->setCreatedAt($now);
            }
        }
        */

        if ($entity instanceof Commande) {
            $num = $this->utils->generateNumCommande();
            $entity->setNumero($num);
        }

        if ($entity instanceof Article) {
            $slug = $this->utils->slugify($entity->getNom());
            $entity->setSlug($slug);
        }
    }


    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (method_exists ($entity, 'setUpdatedAt')) {
            $now = new \DateTime();
            $entity->setUpdatedAt($now);
        }

        /*
        if ($entity instanceof Program) {
            $company = $entity->getCompany();

            if ($company != null) {
                $entity->setPartner($company->getPartner());
            }
        }
        */
    }

    public function preRemove(LifecycleEventArgs $args)
    {

    }

    public function postPersist(LifecycleEventArgs $args)
    {
        //$this->postUpdate($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $em = $args->getObjectManager();
        $entity = $args->getObject();

        /*
        if ($entity instanceof Partner) {
            $admin = $entity->getAdmin();
            if ($admin instanceof User) {
                $admin->addRole('ROLE_ADMIN_PARTNER');
                $em->persist($admin);
                $em->flush();
            }
        }
        */
    }
}
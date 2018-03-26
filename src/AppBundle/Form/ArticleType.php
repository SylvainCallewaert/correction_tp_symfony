<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('prix')
            ->add('prix2')
            ->add('stock')
            ->add('valider', SubmitType::class)

            /*
                par exemple pour faire des vérifications dans cette classe
               qui seront appelé par le service validator
            */
            ->addEventListener(
                FormEvents::POST_SUBMIT,
                array($this, 'onPreSubmit')
            )
        ;
    }

    public function onPreSubmit(FormEvent $event)
    {
        $entity = $event->getData();
        $form = $event->getForm();

        if (mb_strlen($entity->getNom()) > 10) {
            $form->addError(new FormError("Nom trop long"));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }


}

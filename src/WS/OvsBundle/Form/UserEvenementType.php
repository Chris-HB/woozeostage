<?php

namespace WS\OvsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserEvenementType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('statut', 'choice', array('choices' => array('En attente' => 'En attente', 'Refusé' => 'Refusé')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'WS\OvsBundle\Entity\UserEvenement'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ws_ovsbundle_userevenement';
    }

}

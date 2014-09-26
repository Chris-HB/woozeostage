<?php

namespace WS\OvsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserEvenementGererType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('user', 'entity', array(
                    'class' => 'WSUserBundle:User',
                    'property' => 'username',
                    'label' => 'utilisateur',
                    'disabled' => true
                ))
                ->add('statut', 'choice', array(
                    'choices' => array(1 => 'Validé', 2 => 'En attente', 3 => 'Refusé'),
                    'expanded' => true,
                ))
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
        return 'ws_ovsbundle_userevenementgerer';
    }

}

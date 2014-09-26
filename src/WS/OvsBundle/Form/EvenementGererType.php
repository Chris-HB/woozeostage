<?php

namespace WS\OvsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvenementGererType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('userEvenements', 'collection', array(
                    'type' => new UserEvenementGererType(),
                    'label' => 'liste des personnes inscrites à l\'évènement',
                    'options' => array('label' => false)
                ))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'WS\OvsBundle\Entity\Evenement'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ws_ovsbundle_evenementgerer';
    }

}

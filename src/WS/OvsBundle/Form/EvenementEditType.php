<?php

namespace WS\OvsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class EvenementEditType extends EvenementType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder
                ->add('modification', 'textarea', array(
                    'label' => 'raison du changement',
                    'constraints' => array(new NotBlank())
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
        return 'ws_ovsbundle_evenementedit';
    }

}

<?php

namespace WS\OvsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WS\OvsBundle\Entity\EvenementRepository;

class RechercheType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//                ->add('ville', 'text', array(
//                    'required' => false,
//                    'constraints' => array(new NotBlank())
//                ))
                ->add('evenement', 'entity', array(
                    'class' => 'WSOvsBundle:Evenement',
                    'property' => 'ville',
                    'query_builder' => function(EvenementRepository $e) {
                        return $e->rechercheVille();
                    },
                    'required' => false,
                    'label' => 'ville'
                ))
                ->add('sport', 'entity', array(
                    'class' => 'WSOvsBundle:Sport',
                    'property' => 'nom',
                    'required' => false
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
//            'data_class' => 'WS\OvsBundle\Entity\Sport'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'ws_ovsbundle_recherche';
    }

}

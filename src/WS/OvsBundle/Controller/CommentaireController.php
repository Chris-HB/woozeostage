<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Commentaire;
use WS\OvsBundle\Form\CommentaireType;
use WS\OvsBundle\Entity\Evenement;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends Controller {

    /**
     * @Route("/add/{id}", name="ws_ovs_commentaire_add")
     * @Template()
     */
    public function addAction(Evenement $evenement) {
        $commentaire = new Commentaire();
        $user = $this->getUser();
        $form = $this->createForm(new CommentaireType(), $commentaire);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $commentaire->setEvenement($evenement);
                $commentaire->setUser($user);
                $em->persist($commentaire);
                $em->flush();
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            }
        }
        return array('form' => $form->createView(), 'commentaire' => $commentaire, 'evenement' => $evenement);
    }

    /**
     * @Route("/modifier/{id}", name="ws_ovs_commentaire_modifier")
     * @Template()
     */
    public function modifierAction(Commentaire $commentaire) {
        $user = $this->getUser();
        $form = $this->createForm(new CommentaireType(), $commentaire);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $commentaire->setUserEdition($user);
                $commentaire->setDateEdition(new \DateTime());
                $em->persist($commentaire);
                $em->flush();
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $commentaire->getEvenement()->getId())));
            }
        }
        return array('form' => $form->createView(), 'commentaire' => $commentaire);
    }

    /**
     * @Route("/supprimer/{id}", name="ws_ovs_commentaire_desactiver")
     * @Template()
     */
    public function desactiverAction(Commentaire $commentaire) {
        $form = $this->createFormBuilder()->getForm();
        $evenement = $commentaire->getEvenement();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $commentaire->setActif(0);
                $em->persist($commentaire);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Commentaire bien supprimé');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $commentaire->getEvenement()->getId())));
            }
        }
        return array('form' => $form->createView(), 'commentaire' => $commentaire);
    }

    /**
     * @Route("/list/{id}", name="ws_ovs_commentaire_list")
     * @Template()
     */
    public function listAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository('WSOvsBundle:Commentaire')->findBy(array('evenement' => $evenement, 'actif' => 1), array('dateCreation' => 'ASC'));
        return array('commentaires' => $commentaires);
    }

}

<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
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
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode qui ajoute un commentaire en base.
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
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode qui permet de modifié le commentaire passer en parametre.
     */
    public function modifierAction(Commentaire $commentaire) {
        $user = $this->getUser();
        $form = $this->createForm(new CommentaireType(), $commentaire);
        if ($user != $commentaire->getUser()) {
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $commentaire->getEvenement()->getId())));
        }
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
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode qui desactive(actif passe a 0) un commentaire.
     * La route contient supprimer mais en réaliter le commentaire est juste désactiver.
     */
    public function desactiverAction(Commentaire $commentaire) {
        $user = $this->getUser();
        $form = $this->createFormBuilder()->getForm();
        if ($user != $commentaire->getUser()) {
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $commentaire->getEvenement()->getId())));
        }
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
     *
     * Méthode qui renvoie tout les commentaires actif pour un évnement donner.
     */
    public function listAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository('WSOvsBundle:Commentaire')->findBy(array('evenement' => $evenement, 'actif' => 1), array('dateCreation' => 'DESC'));
        return array('commentaires' => $commentaires);
    }

}

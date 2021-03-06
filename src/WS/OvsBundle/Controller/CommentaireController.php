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
     * Méthode qui permet de modifier le commentaire passé en paramètre.
     */
    public function modifierAction(Commentaire $commentaire) {
        $user = $this->getUser();
        $form = $this->createForm(new CommentaireType(), $commentaire);
        // Si l'utilisateur courant n'ai pas celui qui a écrit le commentaire alors on le redirige sur l'événement
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
     * Méthode qui désactive(actif passe a 0) un commentaire.
     * La route contient supprimer mais en réalité le commentaire est juste désactivé.
     */
    public function desactiverAction(Commentaire $commentaire) {
        $user = $this->getUser();
        $form = $this->createFormBuilder()->getForm();
        // Si l'utilisateur courant n'ai pas celui qui a écrit le commentaire alors on le redirige sur l'événement
        if ($user != $commentaire->getUser()) {
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $commentaire->getEvenement()->getId())));
        }
        $evenement = $commentaire->getEvenement();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                // on desactive le commentaire actif passe a 0
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
     * Méthode qui renvoie tout les commentaires actif pour un événement donné.
     */
    public function listAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        // les commentaires actif(1)
        $commentaires = $em->getRepository('WSOvsBundle:Commentaire')->findBy(array('evenement' => $evenement, 'actif' => 1), array('dateCreation' => 'DESC'));
        return array('commentaires' => $commentaires);
    }

}

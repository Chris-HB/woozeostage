<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Entity\UserEvenement;
use WS\OvsBundle\Form\UserEvenementType;

/**
 * @Route("/userevenement")
 */
class UserEvenementController extends Controller {

    /**
     * @Route("/add/{id}", name="ws_ovs_userevenement_add")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode pour ajouter sa participation à un événement.
     * Le créateur de l'événement est automatiquement considéré comme validé pour la participation.
     * L'événement ne doit pas etre encore passé.
     */
    public function addAction(Evenement $evenement) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if ($this->verifDate($evenement)) {
            $this->get('session')->getFlashBag()->add('info', 'Cet événement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            $userEvenementVerif = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement, 'actif' => 1));
            if ($userEvenementVerif != null) {
                $this->get('session')->getFlashBag()->add('info', 'Vous êtes déjà inscrit à cet événement');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            } else {
                // On verifie si l'utilisateur n'a pas déjà annuler sa participaton a cet événement.
                $userEvenementVerifActif = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement, 'actif' => 0));
                if ($userEvenementVerifActif != null) {
                    // Si c'est le cas on le remet actif et "en attente": statut(2).
                    $userEvenementVerifActif->setActif(1);
                    $userEvenementVerifActif->setStatut(2);
                    $em->persist($userEvenementVerifActif);
                    $em->flush();
                    return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
                } else {
                    // Sinon c'est un nouvel utilisateur.
                    $userEvenement = new UserEvenement();
                    $userEvenement->setUser($user);
                    $userEvenement->setEvenement($evenement);
                    // Si c'est le créateur de l'événement on lui met le statut(1) "validé".
                    if ($user == $evenement->getUser()) {
                        $userEvenement->setStatut(1);
                    } else {
                        // Sinon il a le statut(2) "en attente".
                        $userEvenement->setStatut(2);
                    }
                    // Dans le cas du créateur de l'événement on incrémente le nombre d'inscrit validé de l'événement.
                    if ($userEvenement->getStatut() == 1) {
                        $evenement->setNombreValide($evenement->getNombreValide() + 1);
                        $em->persist($evenement);
                    }
                    $em->persist($userEvenement);

                    $em->flush();
                    return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
                }
            }
        }
    }

    /**
     * Route("/modifier/{id}", name="ws_ovs_userevenement_modifier")
     * Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * NE SERT PLUS
     *
     * Méthode pour modifier sa participation à l'événement.
     * L'événement ne doit pas être encore passé.
     * Le créateur de l'événement ne peut pas modifier sa participation.
     */
    public function modifierAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if ($this->verifDate($evenement)) {
            $this->get('session')->getFlashBag()->add('info', 'Cet événement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            if ($user == $evenement->getUser()) {
                $this->get('session')->getFlashBag()->add('info', 'Vous ne pouvez pas modifier votre participation');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            } else {
                $userEvenement = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement));
                $statut = $userEvenement->getStatut();
                $form = $this->createForm(new UserEvenementType(), $userEvenement);
                $request = $this->get('request');
                if ($request->getMethod() == 'POST') {
                    $form->bind($request);
                    if ($form->isValid()) {
                        if ($statut == 1) {
                            $evenement->setNombreValide($evenement->getNombreValide() - 1);
                        }
                        $em->persist($userEvenement, $evenement);
                        $em->flush();
                        return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
                    }
                }
                return array('form' => $form->createView(), 'userEvenement' => $userEvenement);
            }
        }
    }

    /**
     * @Route("/modifierevenment/{id}", name="ws_ovs_userevenement_modifierevenement")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode qui va mettre tous les inscrits en "en attente" sauf le créateur de l'événement.
     * Elle est appellée en cas de modification de l'événement.
     */
    public function modifierEvenementAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        foreach ($evenement->getUserEvenements() as $userEvenement) {
            if ($userEvenement->getUser() == $evenement->getUser()) {
                $userEvenement->setStatut(1);
            } else {
                $userEvenement->setStatut(2);
            }
            $em->persist($userEvenement);
        }
        $em->flush();
        return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
    }

    /**
     * @Route("/annuler/{id}", name="ws_ovs_userevenement_annuler")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode pour annuler sa participation à l'événement.
     * L'événement ne doit pas être encore passé.
     * Le créateur de l'événement ne peut pas annuler sa participation.
     */
    public function annulerAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if ($this->verifDate($evenement)) {
            $this->get('session')->getFlashBag()->add('info', 'Cet événement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            if ($user == $evenement->getUser()) {
                $this->get('session')->getFlashBag()->add('info', 'Vous ne pouvez pas annuler votre participation');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            } else {
                $userEvenement = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement));
                $statut = $userEvenement->getStatut();
                $form = $this->createFormBuilder()->getForm();
                $request = $this->get('request');
                if ($request->getMethod() == 'POST') {
                    $form->bind($request);
                    if ($form->isValid()) {
                        // Si le statut était validé (1) alors on diminue le nombre d'inscrit validé de 1
                        if ($statut == 1) {
                            $evenement->setNombreValide($evenement->getNombreValide() - 1);
                        }
                        // on passe l'utilisateur en inactif
                        $userEvenement->setActif(0);
                        $em->persist($userEvenement, $evenement);
                        $em->flush();
                        return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
                    }
                }
                return array('form' => $form->createView(), 'userEvenement' => $userEvenement);
            }
        }
    }

    /**
     *
     * @param Evenement $evenement
     * @return type
     *
     * Méthode pour verifier que la date actuel n'ai pas suppérieure a la date de l'événement
     */
    public function verifDate(Evenement $evenement) {
        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        return $dateActuelle > $dateEvenement;
    }

}

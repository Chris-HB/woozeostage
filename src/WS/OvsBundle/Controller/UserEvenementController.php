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
     * Méthode pour ajouter sa participation a un évènement.
     * Le créateur de l'évènement est automatiquement considerer comme validé pour la participation.
     * L'évènement ne doit pas etre oncore passé.
     */
    public function addAction(Evenement $evenement) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        if ($dateActuelle > $dateEvenement) {
            $this->get('session')->getFlashBag()->add('info', 'Cet événement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            $userEvenementVerif = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement, 'actif' => 1));
            if ($userEvenementVerif != null) {
                $this->get('session')->getFlashBag()->add('info', 'Vous êtes déjà inscrit à cette sortie');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            } else {
                $userEvenementVerifActif = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement, 'actif' => 0));
                if ($userEvenementVerifActif != null) {
                    $userEvenementVerifActif->setActif(1);
                    $userEvenementVerifActif->setStatut(2);
                    $em->persist($userEvenementVerifActif);
                    $em->flush();
                    return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
                } else {
                    $userEvenement = new UserEvenement();
                    $userEvenement->setUser($user);
                    $userEvenement->setEvenement($evenement);
                    if ($user == $evenement->getUser()) {
                        $userEvenement->setStatut(1);
                    } else {
                        $userEvenement->setStatut(2);
                    }
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
     * Méthode pour modifié sa participation a l'évènement.
     * L'évènement ne doit pas être encore passé.
     * Le créateur de lévènement ne peut pas modifier sa participation.
     */
    public function modifierAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        if ($dateActuelle > $dateEvenement) {
            $this->get('session')->getFlashBag()->add('info', 'Cette evenement est déjà passé');
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
     * Méthode qui va mettre toutes les inscrit en "en attente" sauf le créateur de lévènement.
     * Elle est appeller en cas de modification de l'évènement.
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
     * Méthode pour annuler sa participation a l'évènement.
     * L'évènement ne doit pas être encore passé.
     * Le créateur de lévènement ne peut pas annuler sa participation.
     */
    public function annulerAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        if ($dateActuelle > $dateEvenement) {
            $this->get('session')->getFlashBag()->add('info', 'Cette evenement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            if ($user == $evenement->getUser()) {
                $this->get('session')->getFlashBag()->add('info', 'Vous ne pouvez pas modifier votre participation');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            } else {
                $userEvenement = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement));
                $statut = $userEvenement->getStatut();
                $form = $this->createFormBuilder()->getForm();
                $request = $this->get('request');
                if ($request->getMethod() == 'POST') {
                    $form->bind($request);
                    if ($form->isValid()) {
                        if ($statut == 1) {
                            $evenement->setNombreValide($evenement->getNombreValide() - 1);
                        }
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

}

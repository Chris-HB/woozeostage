<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Form\EvenementType;
use WS\OvsBundle\Form\EvenementEditType;
use WS\OvsBundle\Entity\UserEvenement;
use WS\OvsBundle\Form\EvenementGererType;

/**
 * @Route("/evenement")
 */
class EvenementController extends Controller {

    /**
     * @Route("/add", name="ws_ovs_evenement_add")
     * @Template()
     *
     * Méthode qui ajoute un évènement en base.
     */
    public function addAction() {
        $evenement = new Evenement();
        $form = $this->createForm(new EvenementType(), $evenement);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $user = $this->getUser();
                $evenement->setUser($user);
                $em->persist($evenement);
                $em->flush();
                return $this->redirect($this->generateUrl('ws_ovs_userevenement_add', array('id' => $evenement->getId())));
            }
        }
        return array('form' => $form->createView(), 'evenement' => $evenement);
    }

    /**
     * @Route("/list", name="ws_ovs_evenement_list")
     * @Template()
     *
     * Méthode qui liste tout les évènement quque soit leur date.
     * Trié par heure croissante.
     */
    public function listAction() {
        $em = $this->getDoctrine()->getManager()->getRepository('WSOvsBundle:Evenement');
        $evenements = $em->findBy(array('actif' => 1), array('heure' => 'ASC'));
        return array('evenements' => $evenements);
    }

    /**
     * @param type $date
     * @return type
     *
     * @Route("/listDate/{date}", name="ws_ovs_evenement_listdate", options={"expose"=true})
     * @Template()
     *
     * Méthode qui renvoie la liste des évènements pour une date donner en paramètre.
     * Trié par heure croissante.
     */
    public function listDateAction($date) {
        $date = new \DateTime($date);
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('WSOvsBundle:Evenement')->findBy(array('actif' => 1, 'date' => $date), array('heure' => 'ASC'));

        return array('date' => $date, 'evenements' => $evenements);
    }

    /**
     * @param Evenement $evenement
     *
     * @Route("/voir/{id}", name="ws_ovs_evenement_voir")
     * @Template()
     *
     * Méthode qui permet de voir un évènement.
     */
    public function voirAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();

        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);

        $userEvenementValides = $em->getRepository('WSOvsBundle:UserEvenement')->findBy(array('statut' => 1, 'evenement' => $evenement));
        $userEvenementAttentes = $em->getRepository('WSOvsBundle:UserEvenement')->findBy(array('statut' => 2, 'evenement' => $evenement));

        return array('evenement' => $evenement, 'dateEvenement' => $dateEvenement, 'userEvenementValides' => $userEvenementValides, 'userEvenementAttentes' => $userEvenementAttentes);
    }

    /**
     * @Route("/supprimer/{id}", name="ws_ovs_evenement_desactiver")
     * @Template()
     *
     * Méthode qui permet de désactivé (actif passe a 0) un évènement.
     * L'utilisateur verra supprimer, mais elle ne fait que désactiver l'évènement.
     * L'évènement ne doit pas être encore passé.
     * La méthode désactive également les donnée de la table "userevenement" et les commentaires.
     */
    public function desactiverAction(Evenement $evenement) {
        $user = $this->getUser();
        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        if ($dateActuelle > $dateEvenement) {
            $this->get('session')->getFlashBag()->add('info', 'Cette evenement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            if ($user != $evenement->getUser()) {
                $this->get('session')->getFlashBag()->add('info', 'Vous n\'avez pas les droits pour supprimer cette sortie');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            } else {
                $date = $evenement->getDate()->format('Y-m-d');
                $form = $this->createFormBuilder()->getForm();
                $request = $this->get('request');
                if ($request->getMethod() == 'POST') {
                    $form->bind($request);
                    if ($form->isValid()) {
                        $em = $this->getDoctrine()->getManager();
                        $evenement->setActif(0);
                        $em->persist($evenement);
                        foreach ($evenement->getUserEvenements() as $userEvenement) {
                            $userEvenement->setActif(0);
                            $em->persist($userEvenement);
                        }
                        foreach ($evenement->getCommentaires() as $commentaire) {
                            $commentaire->setActif(0);
                            $em->persist($commentaire);
                        }
                        $em->flush();
                        $this->get('session')->getFlashBag()->add('info', 'Evènement bien supprimé');
                        return $this->redirect($this->generateUrl('ws_ovs_evenement_listdate', array('date' => $date)));
                    }
                }
                return array('form' => $form->createView(), 'evenement' => $evenement);
            }
        }
    }

    /**
     *
     * @param Evenement $evenement
     * @Route("/gerer/{id}", name="ws_ovs_evenement_gerer")
     * @Template()
     *
     * Méthode pour géré les inscrit a un évènement.
     * L'évènement ne doit pas être encore passé.
     */
    public function gererAction(Evenement $evenement) {
        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        if ($dateActuelle > $dateEvenement) {
            $this->get('session')->getFlashBag()->add('info', 'Cette evenement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            $form = $this->createForm(new EvenementGererType(), $evenement);
            $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $nombre = 0;
                    foreach ($evenement->getUserEvenements()as $userEvenement) {
                        if ($userEvenement->getUser() == $evenement->getUser()) {
                            $userEvenement->setStatut(1);
                        }
                        if ($userEvenement->getStatut() == 1) {
                            $nombre ++;
                        }
                        if ($nombre > $evenement->getInscrit()) {
                            $userEvenement->setStatut(2);
                            $nombre --;
                        }
                        $em->persist($userEvenement);
                    }
                    $evenement->setNombreValide($nombre);
                    $em->persist($evenement);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('info', 'liste des personnes inscrites bien modifié');
                    return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
                }
            }
            return array('form' => $form->createView(), 'evenement' => $evenement);
        }
    }

    /**
     * @Route("/modifier/{id}", name="ws_ovs_evenement_modifier")
     * @Template()
     * Méthode pour modifié un évènement.
     * Elle bascule sur la méthode modifierEvenement du UserEvenementController.
     * Lévènement ne doit pas être encore passé.
     */
    public function modifierAction(Evenement $evenement) {
        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        if ($dateActuelle > $dateEvenement) {
            $this->get('session')->getFlashBag()->add('info', 'Cette evenement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            $form = $this->createForm(new EvenementEditType(), $evenement);

            $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($evenement);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('info', 'Evènement bien modifié, merci de gérer les utilisateurs inscrits');
                    return $this->redirect($this->generateUrl('ws_ovs_userevenement_modifierevenement', array('id' => $evenement->getId())));
                }
            }
            return array('form' => $form->createView(), 'evenement' => $evenement);
        }
    }

}

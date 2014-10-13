<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Form\EvenementType;
use WS\OvsBundle\Form\EvenementEditType;
use WS\OvsBundle\Entity\UserEvenement;
use WS\OvsBundle\Form\EvenementGererType;
use WS\UserBundle\Entity\User;
use WS\UserBundle\Entity\Ami;

/**
 * @Route("/evenement")
 */
class EvenementController extends Controller {

    /**
     * @Route("/add", name="ws_ovs_evenement_add")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode qui ajoute un événement en base.
     */
    public function addAction() {
        $evenement = new Evenement();
        $map = $this->get('ivory_google_map.map');
        $form = $this->createForm(new EvenementType(), $evenement);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
                $dateEvenement = new \DateTime($dateE);
                $dateActuelle = new \DateTime();
                if ($dateActuelle > $dateEvenement) {
                    $this->get('session')->getFlashBag()->add('info', 'Vous ne pouvez pas créer un événement qui est déjà passé.');
                    return array('form' => $form->createView(), 'evenement' => $evenement, 'map' => $map);
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $user = $this->getUser();
                    $evenement->setUser($user);
                    $em->persist($evenement);
                    $em->flush();
                    return $this->redirect($this->generateUrl('ws_ovs_userevenement_add', array('id' => $evenement->getId())));
                }
            }
        }
        return array('form' => $form->createView(), 'evenement' => $evenement, 'map' => $map);
    }

    /**
     * @param type $date
     * @return type
     *
     * @Route("/listDate/{date}", name="ws_ovs_evenement_listdate", options={"expose"=true})
     * @Template()
     *
     * Méthode qui renvoie la liste des événements pour une date donnée en paramètre.
     * Trié par heure croissante.
     */
    public function listDateAction($date) {
        $date = new \DateTime($date);
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('WSOvsBundle:Evenement')->findBy(array('actif' => 1, 'date' => $date, 'type' => 'public'), array('heure' => 'ASC'));
        $user = $this->getUser();
        $evenement_privs = null;
        if ($user != null) {
            $amis = $em->getRepository('WSUserBundle:Ami')->findBy(array('user' => $user, 'statut' => 1, 'actif' => 1));
            $evenement_privs = $em->getRepository('WSOvsBundle:Evenement')->sortiePriverDate($date, $user, $amis);
        } else {
            $evenement_privs = null;
        }


        return array('date' => $date, 'evenements' => $evenements, 'evenement_privs' => $evenement_privs);
    }

    /**
     * @param Evenement $evenement
     *
     * @Route("/voir/{id}", name="ws_ovs_evenement_voir")
     * @Template()
     *
     * Méthode qui permet de voir un événement.
     */
    public function voirAction(Evenement $evenement) {
        $map = $this->get('ivory_google_map.map');
        $em = $this->getDoctrine()->getManager();

        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);

        $userEvenementValides = $em->getRepository('WSOvsBundle:UserEvenement')->findBy(array('statut' => 1, 'evenement' => $evenement, 'actif' => 1));
        $userEvenementAttentes = $em->getRepository('WSOvsBundle:UserEvenement')->findBy(array('statut' => 2, 'evenement' => $evenement, 'actif' => 1));

        return array('evenement' => $evenement, 'dateEvenement' => $dateEvenement, 'userEvenementValides' => $userEvenementValides, 'userEvenementAttentes' => $userEvenementAttentes, 'map' => $map);
    }

    /**
     * @Route("/supprimer/{id}", name="ws_ovs_evenement_desactiver")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode qui permet de désactiver (actif passe a 0) un événement.
     * L'utilisateur verra supprimer, mais elle ne fait que désactiver l'événement.
     * L'événement ne doit pas être encore passé.
     * La méthode désactive également les données de la table "userevenement" et les commentaires.
     */
    public function desactiverAction(Evenement $evenement) {
        $user = $this->getUser();
        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        if ($dateActuelle > $dateEvenement) {
            $this->get('session')->getFlashBag()->add('info', 'Cet événement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            if ($user != $evenement->getUser()) {
                $this->get('session')->getFlashBag()->add('info', 'Vous n\'avez pas les droits pour supprimer cet événement');
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
//                        foreach ($evenement->getUserEvenements() as $userEvenement) {
//                            if ($evenement->getUser() != $userEvenement->getUser()) {
//                                messageSupprimer($userEvenement->getUser(), $evenement);
//                            }
//                        }
                        $this->get('session')->getFlashBag()->add('info', 'Evénement bien supprimé');
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
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode pour gérer les inscrits à un événement.
     * L'événement ne doit pas être encore passé.
     */
    public function gererAction(Evenement $evenement) {
        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        $user = $this->getUser();
        if ($dateActuelle > $dateEvenement) {
            $this->get('session')->getFlashBag()->add('info', 'Cet événement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            if ($user != $evenement->getUser()) {
                $this->get('session')->getFlashBag()->add('info', 'Vous n\'avez pas les droits pour gérer cet événement');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            } else {
                $em = $this->getDoctrine()->getManager();
                $userEvenements = $em->getRepository('WSOvsBundle:UserEvenement')->findBy(array('evenement' => $evenement, 'actif' => 1));
                $form = $this->createForm(new EvenementGererType(), $evenement);
                $request = $this->get('request');
                if ($request->getMethod() == 'POST') {
                    $form->bind($request);
                    if ($form->isValid()) {
                        $nombre = 0;
                        $users = [];
                        foreach ($evenement->getUserEvenements()as $userEvenement) {
                            if ($userEvenement->getUser() == $evenement->getUser()) {
                                $userEvenement->setStatut(1);
                            }
                            if ($userEvenement->getStatut() == 1) {
                                $nombre++;
                            }
                            if ($nombre > $evenement->getInscrit()) {
                                $userEvenement->setStatut(2);
                                $nombre--;
                            }
                            $userEvenementOld = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('evenement' => $evenement, 'user' => $evenement->getUser()));
                            if (($userEvenementOld->getStatut() != $userEvenement->getStatut()) && ($userEvenement->getStatut() == 1)) {
                                $users = $userEvenement->getUser();
                            }
                            $em->persist($userEvenement);
                        }
                        $evenement->setNombreValide($nombre);
                        $em->persist($evenement);
                        $em->flush();
//                    foreach ($users as $user) {
//                        message($user, $evenement);
//                    }
                        $this->get('session')->getFlashBag()->add('info', 'liste des personnes inscrites bien modifié');
                        return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
                    }
                }
                return array('form' => $form->createView(), 'evenement' => $evenement);
            }
        }
    }

    /**
     * @Route("/modifier/{id}", name="ws_ovs_evenement_modifier")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode pour modifier un événement.
     * Elle bascule sur la méthode modifierEvenement du UserEvenementController.
     * L'événement ne doit pas être encore passé.
     */
    public function modifierAction(Evenement $evenement) {
        $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
        $dateEvenement = new \DateTime($dateE);
        $dateActuelle = new \DateTime();
        $user = $this->getUser();
        if ($dateActuelle > $dateEvenement) {
            $this->get('session')->getFlashBag()->add('info', 'Cet événement est déjà passé');
            return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
        } else {
            if ($user != $evenement->getUser()) {
                $this->get('session')->getFlashBag()->add('info', 'Vous n\'avez pas les droits pour modifier cet événement');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            } else {
                $map = $this->get('ivory_google_map.map');
                $form = $this->createForm(new EvenementEditType(), $evenement);

                $request = $this->get('request');
                if ($request->getMethod() == 'POST') {
                    $form->bind($request);
                    if ($form->isValid()) {
                        $em = $this->getDoctrine()->getManager();
                        $user = $this->getUser();
                        $evenement->setUserEdition($user);
                        $evenement->setDateEdition(new \DateTime());
                        $em->persist($evenement);
                        $em->flush();
//                    foreach ($evenement->getUserEvenements() as $userEvenement) {
                        //                        if ($evenement->getUser() != $userEvenement->getUser()) {
//                            messageNon($userEvenement->getUser(), $evenement);
//                        }
//                    }
                        $this->get('session')->getFlashBag()->add('info', 'Evénement bien modifié, merci de gérer les utilisateurs inscrits');
                        return $this->redirect($this->generateUrl('ws_ovs_userevenement_modifierevenement', array('id' => $evenement->getId())));
                    }
                }
                return array('form' => $form->createView(), 'evenement' => $evenement, 'map' => $map);
            }
        }
    }

    public function messageConfirm(User $user, Evenement $evenement) {
        $message = \Swift_Message::newInstance()
                ->setSubject('confirmation sortie')
                ->setFrom('A REMPLIR')
                ->setTo($user->getEmail())
                ->setBody($this->renderView('WSovsBundle:Evenement:emailConfirm.txt.twig', array(
                    'user' => $user, 'evenement' => $evenement)))
        ;
        $this->get('mailer')->send($message);
    }

    public function messageNon(User $user, Evenement $evenement) {
        $message = \Swift_Message::newInstance()
                ->setSubject('confirmation sortie')
                ->setFrom('A REMPLIR')
                ->setTo($user->getEmail())
                ->setBody($this->renderView('WSovsBundle:Evenement:emailNon.txt.twig', array(
                    'user' => $user, 'evenement' => $evenement)))
        ;
        $this->get('mailer')->send($message);
    }

    public function messageSupprimer(User $user, Evenement $evenement) {
        $message = \Swift_Message::newInstance()
                ->setSubject('confirmation sortie')
                ->setFrom('A REMPLIR')
                ->setTo($user->getEmail())
                ->setBody($this->renderView('WSovsBundle:Evenement:emailSupprimer.txt.twig', array('user' => $user, 'evenement' => $evenement)))
        ;
        $this->get('mailer')->send($message);
    }

}

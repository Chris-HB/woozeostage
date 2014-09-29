<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Form\EvenementType;
use WS\OvsBundle\Entity\UserEvenement;
use WS\OvsBundle\Form\EvenementGererType;

/**
 * @Route("/evenement")
 */
class EvenementController extends Controller {

    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/add", name="ws_ovs_evenement_add")
     * @Template()
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
     */
    public function desactiverAction(Evenement $evenement) {
        $user = $this->getUser();
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
                    $userEvenements = $em->getRepository('WSOvsBundle:UserEvenement')->findBy(array('evenement' => $evenement));
                    foreach ($userEvenements as $userEvenement) {
                        $userEvenement->setActif(0);
                        $em->persist($userEvenement);
                    }
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('info', 'Evènement bien supprimé');
                    return $this->redirect($this->generateUrl('ws_ovs_evenement_listdate', array('date' => $date)));
                }
            }
            return array('form' => $form->createView(), 'evenement' => $evenement);
        }
    }

    /**
     *
     * @param Evenement $evenement
     * @Route("/gerer/{id}", name="ws_ovs_evenement_gerer")
     * @Template()
     */
    public function gererAction(Evenement $evenement) {
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

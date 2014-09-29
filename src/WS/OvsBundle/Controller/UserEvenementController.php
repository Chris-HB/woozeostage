<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
     */
    public function addAction(Evenement $evenement) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $userEvenement = new UserEvenement();
        $userEvenement->setUser($user);
        $userEvenement->setEvenement($evenement);

        if ($user == $evenement->getUser()) {
            $userEvenement->setStatut(1);
        } else {
            $dateE = $evenement->getDate()->format('Y-m-d') . $evenement->getHeure()->format('H:i');
            $dateEvenement = new \DateTime($dateE);
            $dateActuelle = new \DateTime();
            if ($dateActuelle > $dateEvenement) {
                $this->get('session')->getFlashBag()->add('info', 'Cette evenement est déjà passé');
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            } else {
                $userEvenementVerif = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement));
                if ($userEvenementVerif != null) {
                    $this->get('session')->getFlashBag()->add('info', 'Vous êtes déjà inscrit a cette sortie');
                    return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
                } else {
                    $userEvenement->setStatut(2);
                }
            }
        }
        if ($userEvenement->getStatut() == 1) {
            $evenement->setNombreValide($evenement->getNombreValide() + 1);
        }
        $em->persist($userEvenement, $evenement);
        $em->flush();
        return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
    }

    /**
     * @Route("/modifier/{id}", name="ws_ovs_userevenement_modifier")
     * @Template()
     */
    public function modifierAction(Evenement $evenement) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userEvenement = $em->getRepository('WSOvsBundle:UserEvenement')->findOneBy(array('user' => $user, 'evenement' => $evenement));
        $form = $this->createForm(new UserEvenementType(), $userEvenement);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em->persist($userEvenement);
                $em->flush();
                return $this->redirect($this->generateUrl('ws_ovs_evenement_voir', array('id' => $evenement->getId())));
            }
        }
        return array('form' => $form->createView(), 'userEvenement' => $userEvenement);
    }

}

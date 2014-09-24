<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Form\EvenementType;
use WS\OvsBundle\Entity\UserEvenement;

/**
 * @Route("/userevenement")
 */
class UserEvenementController extends Controller {

    /**
     * @Route("/add/{id}", name="ws_ovs_userevenement_add")
     * @Template()
     */
    public function addAction($id) {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('WSOvsBundle:Evenement')->find($id);
        $user = $this->getUser();

        $userEvenement = new UserEvenement();
        $userEvenement->setUser($user);
        $userEvenement->setEvenement($evenement);

        if ($user == $evenement->getUser()) {
            $userEvenement->setStatut("Validé");
        } else {
            $userEvenement()->setStatut("En attente");
        }

        $em->persist($userEvenement);
        $em->flush();
        return $this->redirect($this->generateUrl('ws_ovs_evenement_list'));
    }

}

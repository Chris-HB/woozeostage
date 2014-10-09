<?php

namespace WS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\UserBundle\Entity\User;
use WS\UserBundle\Entity\Ami;

/**
 * @Route("/ami")
 */
class AmiController extends Controller {

    /**
     * @Route("/add/{id}", name="ws_user_ami_add")
     * @Template()
     */
    public function addAction(User $user) {
        $user_actuel = $this->getUser();
        $ami = new Ami();
        $ami->setUser($user_actuel);
        $ami->setUserBis($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($ami);
        $em->flush();
        $this->get('session')->getFlashBag()->add('info', 'Demande d\'ami envoyer');
        return $this->redirect($this->generateUrl('ws_user_user_profil', array('id' => $user->getId())));
    }

    /**
     * @Route("/supprimer/{id}", name="ws_user_ami_desactiver")
     * @Template()
     */
    public function desactiverAction(Ami $ami) {

    }

    /**
     * @Route("/list/{id}", name="ws_user_ami_list")
     * @Template()
     */
    public function listAction(User $user) {

    }

    /**
     * @Route("/gerer/{id}-{accepter}", name="ws_user_ami_gerer")
     * @Template()
     */
    public function gererAction(User $user, $accepter) {
        if (($accepter == 1) or ( $accepter == 0)) {
            $em = $this->getDoctrine()->getManager();
            $user_actuel = $this->getUser();
            $ami_reverse = $em->getRepository('WSUserBundle:Ami')->findOneBy(array('user' => $user, 'userbis' => $user_actuel));
            if ($accepter == 1) {
                $ami = new Ami();
                $ami->setUser($user_actuel);
                $ami->setUserbis($user);
                $ami->setStatut(1);
                $ami_reverse->setStatut(1);
                $em->persist($ami, $ami_reverse);
                $this->get('session')->getFlashBag()->add('info', 'Ami accepter');
            } else {
                $ami_reverse->setActif(0);
                $em->persist($ami_reverse);
                $this->get('session')->getFlashBag()->add('info', 'Ami refuser');
            }
            $em->flush();
            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        } else {
            $this->get('session')->getFlashBag()->add('info', 'tentative de hack');
            return $this->redirect($this->generateUrl('ws_ovs_accueil_index'));
        }
    }

}

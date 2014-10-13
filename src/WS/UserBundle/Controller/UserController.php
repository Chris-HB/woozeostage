<?php

namespace WS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\UserBundle\Entity\User;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Entity\UserEvenement;
use WS\UserBundle\Entity\Ami;

/**
 * @Route("/user")
 */
class UserController extends Controller {

    /**
     * @Route("/profil/{id}", name="ws_user_user_profil")
     * @Template()
     */
    public function profilAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = null;
        if (is_numeric($id)) {
            $user = $em->getRepository('WSUserBundle:User')->findOneBy(array('id' => $id));
        } else {
            $user = $em->getRepository('WSUserBundle:User')->findOneBy(array('username' => $id));
        }
        if ($user == null) {
            $this->get('session')->getFlashBag()->add('info', 'Personne inexistante');
            return $this->redirect($this->generateUrl('ws_ovs_accueil_index'));
        }
        $user_actuel = $this->getUser();
        $ami = null;
        $ami = $em->getRepository('WSUserBundle:Ami')->findOneBy(array('user' => $user_actuel, 'userbis' => $user, 'statut' => 1, 'actif' => 1));
        $userEvenements = $em->getRepository('WSOvsBundle:UserEvenement')->findBy(array('user' => $user, 'actif' => 1, 'statut' => 1));

        $evenement_publics = $em->getRepository('WSOvsBundle:Evenement')->findBy(array('user' => $user, 'actif' => 1, 'type' => 'public'));
        $userEvenement_publics = $this->participationPublic($userEvenements);

        if ($ami != null) {
            $evenement_privs = $em->getRepository('WSOvsBundle:Evenement')->findBy(array('user' => $user, 'actif' => 1, 'type' => 'priver'));
            $userEvenement_privs = $this->participationPriver($userEvenements, $user);
        } else {
            $evenement_privs = null;
            $userEvenement_privs = null;
        }

        return array('user' => $user, 'evenement_publics' => $evenement_publics, 'userEvenement_publics' => $userEvenement_publics, 'ami' => $ami, 'evenement_privs' => $evenement_privs, 'userEvenement_privs' => $userEvenement_privs);
    }

    /**
     * @Template()
     */
    public function whoIsOnlineAction() {
        $users = $this->getDoctrine()->getManager()->getRepository('WSUserBundle:User')->getActive();

        return array('users' => $users);
    }

    public function amiCommun(User $user) {
        $user_actuel = $this->getUser();
        $amis_actuel = $this->getDoctrine()->getManager()->getRepository('WSUserBundle:Ami')->findBy(array('user' => $user_actuel, 'statut' => 1, 'actif' => 1));
        $amis = $this->getDoctrine()->getManager()->getRepository('WSUserBundle:Ami')->findBy(array('user' => $user, 'statut' => 1, 'actif' => 1));
        $amis_commun = array();
        foreach ($amis as $ami) {
            foreach ($amis_actuel as $ami_actuel) {
                if ($ami->getUserbis() == $ami_actuel->getUserbis()) {
                    $amis_commun[] = $ami_actuel;
                }
            }
        }
        return $amis_commun;
    }

    public function participationPublic($userEvenements) {
        $userEvenement_publics = array();
        foreach ($userEvenements as $userEvenement) {
            if ($userEvenement->getEvenement()->getType() == 'public') {
                $userEvenement_publics[] = $userEvenement;
            }
        }
        return $userEvenement_publics;
    }

    public function participationPriver($userEvenements, $user) {
        $userEvenement_privers = array();
        foreach ($userEvenements as $userEvenement) {
            if ($userEvenement->getEvenement()->getType() == 'priver') {
                $userEvenement_privers[] = $userEvenement;
            }
        }
        $amis_commun = $this->amiCommun($user);
        $user_actuel = $this->getUser();
        $evenement_privs = $this->getDoctrine()->getManager()->getRepository('WSOvsBundle:Evenement')->sortiePriverAmi($user_actuel, $user, $amis_commun);

        $userEvenement_privs = array();
        foreach ($userEvenement_privers as $userEvenement_priver) {
            foreach ($evenement_privs as $evenement_priv) {
                if ($userEvenement_priver->getEvenement() == $evenement_priv) {
                    $userEvenement_privs[] = $userEvenement_priver;
                }
            }
        }

        return $userEvenement_privs;
    }

}

<?php

namespace WS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\UserBundle\Entity\User;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Entity\UserEvenement;

/**
 * @Route("/user")
 */
class UserController extends Controller {

    /**
     * @Route("/profil/{id}", name="ws_user_user_profil")
     * @Template()
     */
    public function profilAction(User $user) {
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('WSOvsBundle:Evenement')->findBy(array('user' => $user, 'actif' => 1));
        $userEvenements = $em->getRepository('WSOvsBundle:UserEvenement')->findBy(array('user' => $user, 'actif' => 1, 'statut' => 1));

        return array('user' => $user, 'evenements' => $evenements, 'userEvenements' => $userEvenements);
    }

}

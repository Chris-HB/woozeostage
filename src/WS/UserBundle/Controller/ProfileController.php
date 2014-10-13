<?php

namespace WS\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use WS\UserBundle\Entity\Ami;

class ProfileController extends BaseController {

    /**
     * Show the user
     *
     * Overide de la méthode de voir le profil de FOS
     */
    public function showAction() {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em = $this->getDoctrine()->getManager();
        $amis = $em->getRepository('WSUserBundle:Ami')->findBy(array('user' => $user, 'statut' => 1, 'actif' => 1));
        $amis_att = $em->getRepository('WSUserBundle:Ami')->findBy(array('userbis' => $user, 'statut' => 2, 'actif' => 1));
        $evenements = $em->getRepository('WSOvsBundle:Evenement')->findBy(array('user' => $user, 'actif' => 1));
        $userEvenements = $em->getRepository('WSOvsBundle:UserEvenement')->findBy(array('user' => $user, 'actif' => 1, 'statut' => 1));

        return $this->render('FOSUserBundle:Profile:show.html.twig', array('user' => $user, 'amis' => $amis, 'amis_att' => $amis_att, 'evenements' => $evenements, 'userEvenements' => $userEvenements));
    }

}

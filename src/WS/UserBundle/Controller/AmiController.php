<?php

namespace WS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use WS\UserBundle\Entity\User;
use WS\UserBundle\Entity\Ami;

/**
 * @Route("/ami")
 */
class AmiController extends Controller {

    /**
     * @Route("/add/{id}", name="ws_user_ami_add")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode qui va envoyer une demande d'ami a un utilisateur
     */
    public function addAction(User $user) {
        $em = $this->getDoctrine()->getManager();
        $user_actuel = $this->getUser();
        $ami = $em->getRepository('WSUserBundle:Ami')->findOneBy(array('user' => $user_actuel, 'userbis' => $user));
        // Si ils étaient déja ami ou sont toujours ami
        if ($ami != null) {
            // Si il ne sont plus ami on met a jour le statut et on le repasse en actif pour envoyer une nouvelel demande
            if ($ami->getActif() == 0) {
                $ami->setStatut(2);
                $ami->setActif(1);
                $ami->setNouveau(1);
            } else {
                if ($ami->getStatut() == 1) {
                    $this->get('session')->getFlashBag()->add('info', 'Vous êtes déjà ami');
                    return $this->redirect($this->generateUrl('ws_user_user_profil', array('id' => $user->getId())));
                }
            }
        } else {
            $ami = new Ami();
            $ami->setUser($user_actuel);
            $ami->setUserBis($user);
        }
        $em->persist($ami);
        $em->flush();
        $this->get('session')->getFlashBag()->add('info', 'Demande d\'ami envoyée');
        return $this->redirect($this->generateUrl('ws_user_user_profil', array('id' => $user->getId())));
    }

    /**
     * @Route("/supprimer/{id}", name="ws_user_ami_desactiver")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode pour supprimer un ami.
     * Cette méthode désactive la relation dans les 2 sens.
     */
    public function desactiverAction(User $user) {
        $form = $this->createFormBuilder()->getForm();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $user_actuel = $this->getUser();
                $ami = $em->getRepository('WSUserBundle:Ami')->findOneBy(array('user' => $user_actuel, 'userbis' => $user));
                $ami->setActif(0);
                $ami_reverse = $em->getRepository('WSUserBundle:Ami')->findOneBy(array('user' => $user, 'userbis' => $user_actuel));
                $ami_reverse->setActif(0);
                $em->persist($ami, $ami_reverse);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Ami bien supprimé');
                return $this->redirect($this->generateUrl('fos_user_profile_show'));
            }
        }
        return array('form' => $form->createView(), 'user' => $user);
    }

    /**
     * @Route("/gerer/{id}-{accepter}", name="ws_user_ami_gerer")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode pour accepté ou refusé un ami.
     */
    public function gererAction(User $user, $accepter) {
        if (($accepter == 1) or ( $accepter == 0)) {
            $em = $this->getDoctrine()->getManager();
            $user_actuel = $this->getUser();
            $ami_reverse = $em->getRepository('WSUserBundle:Ami')->findOneBy(array('user' => $user, 'userbis' => $user_actuel));
            if ($accepter == 1) {
                $ami = $em->getRepository('WSUserBundle:Ami')->findOneBy(array('user' => $user_actuel, 'userbis' => $user));
                // Si on accepte et qu'on était déja ami alors on réactive la liaison si elle n'exister plus.
                if ($ami != null) {
                    if ($ami->getActif() == 0) {
                        $ami->setActif(1);
                        $ami->setStatut(1);
                        $ami->setNouveau(1);
                    } else {
                        // On valide la liaison dans le cas d'envoie simultaner.
                        if ($ami->getStatut() == 2) {
                            $ami->setStatut(1);
                            $ami->setNouveau(1);
                        } else {
                            $this->get('session')->getFlashBag()->add('info', 'Vous êtes déjà ami');
                            return $this->redirect($this->generateUrl('fos_user_profile_show'));
                        }
                    }
                } else {
                    $ami = new Ami();
                    $ami->setUser($user_actuel);
                    $ami->setUserbis($user);
                    $ami->setStatut(1);
                }
                $ami_reverse->setNouveau(0);
                $ami_reverse->setStatut(1);
                $em->persist($ami, $ami_reverse);
                $this->get('session')->getFlashBag()->add('info', 'Ami accepté');
            } else {
                // Si on refuse on déscative la demande d'ami.
                $ami_reverse->setActif(0);
                $em->persist($ami_reverse);
                $this->get('session')->getFlashBag()->add('info', 'Ami refusé');
            }
            $em->flush();
            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        } else {
            $this->get('session')->getFlashBag()->add('info', 'tentative de hack');
            return $this->redirect($this->generateUrl('ws_ovs_accueil_index'));
        }
    }

    /**
     * @Route("/annonce", name="ws_user_ami_annonce")
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     * Méthode qui renvoie le nombre de demande d'ami en attente.
     */
    public function annonceAction() {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        //$amis_att = $em->getRepository('WSUserBundle:Ami')->findBy(array('userbis' => $user, 'statut' => 2, 'actif' => 1));
        $amis_att = $em->getRepository('WSUserBundle:Ami')->findBy(array('userbis' => $user, 'nouveau' => 1, 'actif' => 1));

        return array('amis_att' => $amis_att);
    }

}

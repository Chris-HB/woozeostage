<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use WS\OvsBundle\Entity\Commentaire;
use WS\OvsBundle\Form\CommentaireType;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Form\RechercheType;

/**
 * @Route("/recherche")
 */
class RechercheController extends Controller {

    /**
     * @Route("/recherche", name="ws_ovs_recherche_recherche", options={"expose"=true})
     * @Template()
     */
    public function rechercheAction() {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new RechercheType());
        $evenements = null;
        $ville = null;
        $sport = null;
        $user = $this->getUser();
        $amis = null;
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            $ville = $form->get('evenement')->getData();
            $sport = $form->get('sport')->getData();
            $evenement_privs = null;
            if ($user != null) {
                $amis = $em->getRepository('WSUserBundle:Ami')->findBy(array('user' => $user, 'statut' => 1, 'actif' => 1));
            }
            if ($ville != null and $sport == null) {
                $evenements = $em->getRepository('WSOvsBundle:Evenement')->result_Ville($ville->getVille());
                if (!is_null($amis)) {
                    $evenement_privs = $em->getRepository('WSOvsBundle:Evenement')->result_ville_Priver($ville->getVille(), $user, $amis);
                }
            } else {
                if ($ville == null and $sport != null) {
                    $evenements = $em->getRepository('WSOvsBundle:Evenement')->result_Sport($sport->getNom());
                    if (!is_null($amis)) {
                        $evenement_privs = $em->getRepository('WSOvsBundle:Evenement')->result_sport_Priver($sport->getNom(), $user, $amis);
                    }
                } else {
                    $evenements = $em->getRepository('WSOvsBundle:Evenement')->result($ville->getVille(), $sport->getNom());
                    if (!is_null($amis)) {
                        $evenement_privs = $em->getRepository('WSOvsBundle:Evenement')->result_ville_Priver($ville->getVille(), $sport->getNom(), $user, $amis);
                    }
                }
            }
            return $this->render('WSOvsBundle:Recherche:resultrecherche.html.twig', array('evenements' => $evenements, 'ville' => $ville, 'sport' => $sport, 'evenement_privs' => $evenement_privs));
        }

        return array('form' => $form->createView(), 'evenements' => $evenements);
    }

}

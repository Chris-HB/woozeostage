<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            $ville = $form->get('evenement')->getData();
            $sport = $form->get('sport')->getData();
            if ($ville != null and $sport == null) {
                $evenements = $em->getRepository('WSOvsBundle:Evenement')->result_Ville($ville->getVille());
            } else {
                if ($ville == null and $sport != null) {
                    $evenements = $em->getRepository('WSOvsBundle:Evenement')->result_Sport($sport->getNom());
                } else {
                    $evenements = $em->getRepository('WSOvsBundle:Evenement')->result($ville->getVille(), $sport->getNom());
                }
            }
            return $this->render('WSOvsBundle:Recherche:resultrecherche.html.twig', array('evenements' => $evenements, 'ville' => $ville, 'sport' => $sport));
        }

        return array('form' => $form->createView(), 'evenements' => $evenements);
    }

}

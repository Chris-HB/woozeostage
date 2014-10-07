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
        $recherche = null;
        $type = null;
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $recherche = $request->request->get('recherche');
            $type = $request->request->get('type');
            switch ($type) {
                case "ville":
                    $evenements = $em->getRepository('WSOvsBundle:Evenement')->rechercheVille($recherche);
                    break;
                case "sport":
                    $evenements = $em->getRepository('WSOvsBundle:Evenement')->rechercheSport($recherche);
                    break;
            }
            return $this->render('WSOvsBundle:Recherche:rechresult.html.twig', array('evenements' => $evenements, 'type' => $type));
        }
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            $recherche = $form->get('recherche')->getData();
            $type = $form->get('type')->getData();
            switch ($type) {
                case "ville":
                    $evenements = $em->getRepository('WSOvsBundle:Evenement')->resultVille($recherche);
                    break;
                case "sport":
                    $evenements = $em->getRepository('WSOvsBundle:Evenement')->resultSport($recherche);
                    break;
            }
            return $this->render('WSOvsBundle:Recherche:resultrecherche.html.twig', array('evenements' => $evenements));
        }

        return array('form' => $form->createView(), 'evenements' => $evenements, 'type' => $type);
    }

}

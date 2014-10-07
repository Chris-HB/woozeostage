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
     * @Route("/recherche", name="ws_ovs_recherche_recherche")
     * @Template()
     */
    public function rechercheAction() {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new RechercheType());
        $evenements = null;
        $recherche = null;
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $recherche = $request->request->get('recherche');
            //$evenements = $em->getRepository('WSOvsBundle:Evenement')->recherche($recherche);
            // $evenements = $em->getRepository('WSOvsBundle:Evenement')->findAll();
//            return $this->container->get('templating')->renderResponse('WSOvsBundle:Recherche:rechresult.html.twig', array(
//                        'evenements' => $evenements
//            ));
            return $this->render('WSOvsBundle:Recherche:rechresult.html.twig', array('recherche' => $recherche));
        }
//        if ($request->getMethod() == 'POST') {
//            $form->bind('request');
//            $recherche = $form->get('recherche')->getData();
//            $evenements = $em->getRepository('WSOvsBundle:Evenement')->recherche($recherche);
//            return array('evenements' => $evenements, 'form' => $form->createView());
//        }

        return array('form' => $form->createView(), 'recherche' => $recherche);
    }

}

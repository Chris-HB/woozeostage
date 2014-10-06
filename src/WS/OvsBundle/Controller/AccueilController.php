<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Commentaire;
use WS\OvsBundle\Form\CommentaireType;
use WS\OvsBundle\Entity\Evenement;

class AccueilController extends Controller {

    /**
     * @Route("/", name="ws_ovs_accueil_index", options={"expose"=true})
     * @Template()
     */
    public function indexAction() {
        $map = $this->get('ivory_google_map.map');
        $date = new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('WSOvsBundle:Evenement')->findBy(array('actif' => 1, 'date' => $date), array('heure' => 'ASC'));

        return array('date' => $date, 'evenements' => $evenements, 'map' => $map);
    }

}

<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use WS\OvsBundle\Entity\Commentaire;
use WS\OvsBundle\Form\CommentaireType;
use WS\OvsBundle\Entity\Evenement;

/**
 * @Route("/administrateur")
 */
class AdminController extends Controller {

    /**
     * @Route("/listevenement", name="ws_ovs_admin_listevenement", options={"expose"=true})
     * @Template()
     *
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     *
     * Méthode pour afficher la liste de tout les évnement et les trier en fonction de critière.
     */
    public function listEvenementAction() {
        $em = $this->getDoctrine()->getManager()->getRepository('WSOvsBundle:Evenement');
        $evenements = $em->findAll();
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $actif = $request->request->get('actif');
            $tri = $request->request->get('tri');
            switch ($tri) {
                case "date":
                    $evenements = $em->findBy(array('actif' => $actif), array('date' => 'asc', 'heure' => 'asc'));
                    break;
                case "sport":
                    $evenements = $em->triSport($actif);
                    break;
                case "user":
                    $evenements = $em->triUser($actif);
                    break;
                case "ville":
                    $evenements = $em->findBy(array('actif' => $actif), array('ville' => 'asc'));
                    break;
                default:
                    $evenements = $em->findBy(array('actif' => $actif));
            }
            return $this->render('WSOvsBundle:Admin:listEvent.html.twig', array(
                        'evenements' => $evenements
            ));
        }
        return array('evenements' => $evenements);
    }

}

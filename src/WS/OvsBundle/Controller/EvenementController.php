<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Form\EvenementType;

/**
 * @Route("/evenement")
 */
class EvenementController extends Controller {

    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/add/{id}", name="ws_ovs_evenement_add")
     * @Template()
     */
    public function addAction($id) {
        $em = $this->getDoctrine()->getManager()->getRepository('WSOvsBundle:Date');
        $date = $em->find($id);
        $evenement = new Evenement($date);
        $form = $this->createForm(new EvenementType(), $evenement);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $user = $this->getUser();
                $evenement->setUser($user);
                $em->persist($evenement);
                $em->flush();
                return $this->redirect($this->generateUrl('ws_ovs_evenement_list', array('id' => $date->getId())));
            }
        }
        return array('form' => $form->createView(), 'evenement' => $evenement, 'date' => $date);
    }

    /**
     * @Route("/list/{id}", name="ws_ovs_evenement_list")
     * @Template()
     */
    public function listAction($id) {
        $em = $this->getDoctrine()->getManager()->getRepository('WSOvsBundle:Date');
        $date = $em->find($id);

        $em = $this->getDoctrine()->getManager()->getRepository('WSOvsBundle:Evenement');
        $evenements = $em->findBy(array('date' => $date, 'actif' => 1), array('heure' => 'ASC'));
        return array('date' => $date, 'evenements' => $evenements);
    }

}

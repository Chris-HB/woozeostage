<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Sport;
use WS\OvsBundle\Form\SportType;

/**
 * @Route("/sport")
 */
class SportController extends Controller {

    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/add", name="ws_ovs_sport_add")
     * @Template()
     */
    public function addAction() {
        $sport = new Sport();
        $form = $this->createForm(new SportType(), $sport);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($sport);
                $em->flush();
                return $this->redirect($this->generateUrl('ws_ovs_sport_list'));
            }
        }
        return array('form' => $form->createView(), 'sport' => $sport);
    }

    /**
     * @Route("/list", name="ws_ovs_sport_list")
     * @Template()
     */
    public function listAction() {
        $em = $this->getDoctrine()->getManager()->getRepository('WSOvsBundle:Sport');
        $sports = $em->findAll();
        return array('sports' => $sports);
    }

}

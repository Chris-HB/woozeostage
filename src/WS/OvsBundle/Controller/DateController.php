<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Date;
use WS\OvsBundle\Form\DateType;

/**
 * @Route("/date")
 */
class DateController extends Controller {

    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/add", name="ws_ovs_date_add")
     * @Template()
     */
    public function addAction() {
        $date = new Date();
        $form = $this->createForm(new DateType(), $date);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind();
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($date);
                $em->flush();
                return $this->redirect($this->generateUrl());
            }
        }
        return array('form' => $form->createView(), 'date' => $date);
    }

    /**
     * @Route("/list", name="ws_ovs_date_list")
     * @Template()
     */
    public function listAction() {
        $em = $this->getDoctrine()->getManager()->getRepository('WSOvsBundle:Date');
        $dates = $em->findAll();
        return array('dates' => $dates);
    }

}

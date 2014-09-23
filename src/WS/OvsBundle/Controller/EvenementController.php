<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

}

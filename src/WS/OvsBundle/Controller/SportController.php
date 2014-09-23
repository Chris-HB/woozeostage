<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

}

<?php

namespace WS\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ChatController extends Controller {

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {

        return array();
    }

    /**
     * @Route("/listUser", name="ws_chat_listUser")
     * @Template()
     */
    public function listUserAction() {
        $em = $this->getDoctrine()->getManager()->getRepository('WSUserBundle:User');
        $users = $em->findAll();
        return array('users' => $users);
    }

    /**
     * @Route("/voir", name="ws_chat_voir")
     * @Template()
     */
    public function voirAction() {
        return array();
    }

}

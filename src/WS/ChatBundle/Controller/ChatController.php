<?php

namespace WS\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ChatController extends Controller {

    /**
     * @Route("/", name="ws_chat_index")
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
     * @Route("/fichierText", name="ws_chat_fichierText")
     * @Template()
     */
    public function fichierTextAction() {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $emetteur = '';
            $recepteur = '';
            $message = '';
            $emetteur = $request->request->get('emetteur');
            $recepteur = $request->request->get('recepteur');
            $message = $request->request->get('message');
            $monfichier = fopen('contenuBox.txt', 'a+');
            fputs($monfichier, $emetteur);
            fputs($monfichier, "\n");
            fputs($monfichier, $recepteur);
            fputs($monfichier, "\n");
            fputs($monfichier, $message);
            fputs($monfichier, "\n");
            fclose($monfichier);
        }
        return $this->redirect($this->generateUrl('ws_chat_index'));
    }

}

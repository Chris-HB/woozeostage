<?php

namespace WS\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\ChatBundle\Entity\Messagebox;

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
     * @Route("/addMessageBase", name="ws_chat_addMessageBase", options={"expose"=true})
     * @Template()
     */
    public function addMessageBaseAction() {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $emetteur = '';
            $recepteur = '';
            $message = '';
            $emetteur = $request->request->get('emetteur');
            $recepteur = $request->request->get('recepteur');
            $message = $request->request->get('message');

//            $monfichier = fopen('contenuBox.txt', 'a+');
//            fputs($monfichier, $emetteur);
//            fputs($monfichier, "\n");
//            fputs($monfichier, $recepteur);
//            fputs($monfichier, "\n");
//            fputs($monfichier, $message);
//            fputs($monfichier, "\n");
//            fclose($monfichier);

            $em = $this->getDoctrine()->getManager();
            $emetteur = $em->getRepository('WSUserBundle:User')->findOneBy(array('username' => $emetteur));
            $recepteur = $em->getRepository('WSUserBundle:User')->findOneBy(array('username' => $recepteur));
            // On enregistre le message en base
            $mb = new Messagebox();
            $mb->setEmetteur($emetteur);
            $mb->setRecepteur($recepteur);
            $mb->setMessage($message);

            $em->persist($mb);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('ws_chat_index'));
    }

    /**
     * @Route("/varSession", name="ws_chat_varSession", options={"expose"=true})
     * @Template()
     */
    public function varSessionAction() {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $tab = '';
            $tab = $request->request->get('infosbox');
            $session = $request->getSession();
            // mise en session des id des box
            $session->set('infosbox', $tab);

            return new \Symfony\Component\HttpFoundation\Response($tab);
        }

        return $this->redirect($this->generateUrl('ws_chat_index'));
    }

    /**
     * @Route("/recupSession", name="ws_chat_recupSession", options={"expose"=true})
     * @Template()
     */
    public function recupSessionAction() {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $session = $request->getSession();
            $tab = $session->get('infosbox');
            //$tabjson = json_encode($tab);
            //-------------------------------
            // récupération des messages box
            //---
            $messTab = [];
            $em = $this->getDoctrine()->getManager();
            foreach ($tab as $val) {
                $user = $em->getRepository('WSUserBundle:User')->findOneBy(array('username' => $val));
                $messboxes = $em->getRepository('WSChatBundle:Messagebox')->findBy(array('emetteur' => $this->getUser(), 'recepteur' => $user));
                foreach ($messboxes as $messbox) {
                    $elem = [];
                    $elem[] = $messbox->getEmetteur()->getUsername();
                    $elem[] = $messbox->getRecepteur()->getUsername();
                    $elem[] = $messbox->getMessage();
                    $messTab[] = $elem;
                }
            }
            // je crée un tableau des 2 tableaux $tab et $messTab
            $dataTab = [];
            $dataTab[] = $tab;
            $dataTab[] = $messTab;
            // j'encode le tout en JSON
            $dataTabJson = json_encode($dataTab);
        }

        //return $this->redirect($this->generateUrl('ws_chat_index'), array('tabinfo' => $tab));
        return new \Symfony\Component\HttpFoundation\Response($dataTabJson);
    }

}

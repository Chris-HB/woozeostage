<?php

namespace WS\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\ChatBundle\Entity\Messagebox;
use Tembo\Message;
use Tembo\SocketIOClient;

class ChatController extends Controller {

    /**
     * @Route("/chat", name="ws_chat_index")
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
            $emetteur_base = $em->getRepository('WSUserBundle:User')->findOneBy(array('username' => $emetteur));
            $recepteur_base = $em->getRepository('WSUserBundle:User')->findOneBy(array('username' => $recepteur));
            // On enregistre le message en base
            $mb = new Messagebox();
            $mb->setEmetteur($emetteur_base);
            $mb->setRecepteur($recepteur_base);
            $mb->setMessage($message);

            $em->persist($mb);
            $em->flush();
            //------
            // récupération du client
            $faye = $this->get('WS_ChatBundle.faye.client');

            // construction d'un message
            $channel = '/messages';
            $data = array('emetteur' => $emetteur, 'recepteur' => $recepteur, 'message' => $message);


            // envoi du message

            $faye->send($channel, $data);
            //------
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
//        // récupération du client
//        $faye = $this->get('WS_ChatBundle.faye.client');
//
//        // construction d'un message
//
//        $channel = '/messages';
//        $data = array('text' => 'Salut c\'est Bob !');
//
//        // envoi du message
//
//        $faye->send($channel, $data);


        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {

            // je recupère l'id de la box suite au clic sur l'utilisateur
            $idbox = [];
            $idbox = $request->request->get('idbox');
            $session = $request->getSession();

            // si on a cliqué sur un utilisateur je récupére l'id sinon la variable session correspondant aux box ouvertes
            if (!empty($idbox)) {
                $tab = $idbox;
            } else {
                $tab = $session->get('infosbox');
            }
            //-------------------------------
            // récupération des messages box
            //---
            $messTab = [];
            $em = $this->getDoctrine()->getManager();
            foreach ($tab as $val) {
                $user = $em->getRepository('WSUserBundle:User')->findOneBy(array('username' => $val));
                // on recupère les messages dont | emetteur=utilisateur connecté ET recepteur=l'utilisateur recepteur
                //                               | OU emetteur=utilisateur recepteur connecté ET recepteur=utilisateur connecté
                $messboxes = $em->getRepository('WSChatBundle:Messagebox')->findBy(array('emetteur' => array($this->getUser(), $user), 'recepteur' => array($user, $this->getUser())), array('date' => 'DESC'), 5);
                foreach ($messboxes as $messbox) {
                    $elem = [];
                    $elem[] = $messbox->getEmetteur()->getUsername();
                    //$elem[] = $messbox->getRecepteur()->getUsername();
                    $elem[] = $user->getUsername();
                    $elem[] = $messbox->getMessage();
                    $messTab[] = $elem;
                }
            }
            // j'inverse l'ordre du tableau messTab pour remettre les messages dans l'ordre chronologique
            $messTab = array_reverse($messTab);
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

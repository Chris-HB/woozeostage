<?php

namespace WS\OvsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use WS\OvsBundle\Entity\Evenement;
use WS\OvsBundle\Form\EvenementType;
use WS\OvsBundle\Form\EvenementEditType;
use WS\OvsBundle\Entity\UserEvenement;
use WS\OvsBundle\Form\EvenementGererType;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends Controller {

    /**
     * @Route("/add", name="ws_ovs_commentaire_add")
     * @Template()
     */
    public function addAction() {

    }

    /**
     * @Route()
     * @Template()
     */
    public function modifierAction() {

    }

}

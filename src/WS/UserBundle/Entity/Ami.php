<?php

namespace WS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserEvenement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WS\UserBundle\Entity\AmiRepository")
 */
class Ami {

    /**
     * @var type
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="amis")
     */
    private $user;

    /**
     * @var type
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="amisbis")
     */
    private $userbis;

    /**
     * @var type
     *
     * @ORM\Column(name="statut", type="integer")
     *
     * Le staut correspond a 1: validé, 2: en attente.
     */
    private $statut;

    /**
     * @var type
     *
     * @ORM\Column(name="actif", type="boolean")
     *
     * L'ami est soit active(1) quand validé ou en attente ou desactivé(0) si refuser ou supprimer.
     */
    private $actif;

    public function __construct() {
        $this->actif = 1;
        $this->statut = 2;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Ami
     */
    public function setStatut($statut) {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer
     */
    public function getStatut() {
        return $this->statut;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Ami
     */
    public function setActif($actif) {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif() {
        return $this->actif;
    }

    /**
     * Set user
     *
     * @param \WS\UserBundle\Entity\User $user
     * @return Ami
     */
    public function setUser(\WS\UserBundle\Entity\User $user) {
        $this->user = $user;
        $user->addAmi($this);
        return $this;
    }

    /**
     * Get user
     *
     * @return \WS\UserBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set userbis
     *
     * @param \WS\UserBundle\Entity\User $userbis
     * @return Ami
     */
    public function setUserbis(\WS\UserBundle\Entity\User $userbis) {
        $this->userbis = $userbis;
        $userbis->addAmisbi($this);
        return $this;
    }

    /**
     * Get userbis
     *
     * @return \WS\UserBundle\Entity\User
     */
    public function getUserbis() {
        return $this->userbis;
    }

}

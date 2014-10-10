<?php

namespace WS\OvsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserEvenement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WS\OvsBundle\Entity\UserEvenementRepository")
 */
class UserEvenement {

    /**
     * @var type
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="userEvenements")
     *
     * L'utilisateur qui participe à l'événement.
     */
    private $user;

    /**
     * @var type
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="WS\OvsBundle\Entity\Evenement", inversedBy="userEvenements")
     *
     * L'événement.
     */
    private $evenement;

    /**
     * @var type
     *
     * @ORM\Column(name="statut", type="integer")
     *
     * Le statut correspond à 1: validé, 2: en attente, 3 :refusé.
     */
    private $statut;

    /**
     * @var type
     *
     * @ORM\Column(name="actif", type="boolean")
     *
     * La participation est active(1) ou desactivé(0).
     */
    private $actif;

    public function __construct() {
        $this->actif = 1;
    }

    /**
     * Set user
     *
     * @param \WS\UserBundle\Entity\User $user
     * @return UserEvenement
     */
    public function setUser(\WS\UserBundle\Entity\User $user) {
        $this->user = $user;
        $user->addUserEvenement($this);

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
     * Set evenement
     *
     * @param \WS\OvsBundle\Entity\Evenement $evenement
     * @return UserEvenement
     */
    public function setEvenement(\WS\OvsBundle\Entity\Evenement $evenement) {
        $this->evenement = $evenement;
        $evenement->addUserEvenement($this);

        return $this;
    }

    /**
     * Get evenement
     *
     * @return \WS\OvsBundle\Entity\Evenement
     */
    public function getEvenement() {
        return $this->evenement;
    }

    /**
     * Set statut
     *
     * @param string $statut
     * @return UserEvenement
     */
    public function setStatut($statut) {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut() {
        return $this->statut;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return UserEvenement
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

}

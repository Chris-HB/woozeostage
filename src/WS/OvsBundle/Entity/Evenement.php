<?php

namespace WS\OvsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WS\OvsBundle\Entity\EvenementRepository")
 */
class Evenement {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="inscrit", type="integer")
     */
    private $inscrit;

    /**
     *
     * @var type
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="evenements")
     */
    private $user;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="WS\OvsBundle\Entity\Sport", inversedBy="evenements")
     */
    private $sport;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="WS\OvsBundle\Entity\Date", inversedBy="evenements")
     */
    private $date;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\OvsBundle\Entity\UserEvenement", mappedBy="evenement")
     */
    private $userEvenements;

    /**
     * Constructor
     */
    public function __construct() {
        $this->userEvenements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Evenement
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set inscrit
     *
     * @param integer $inscrit
     * @return Evenement
     */
    public function setInscrit($inscrit) {
        $this->inscrit = $inscrit;

        return $this;
    }

    /**
     * Get inscrit
     *
     * @return integer
     */
    public function getInscrit() {
        return $this->inscrit;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Evenement
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
     * @return Evenement
     */
    public function setUser(\WS\UserBundle\Entity\User $user = null) {
        $this->user = $user;
        $user->addEvenement($this);

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
     * Set sport
     *
     * @param \WS\OvsBundle\Entity\Sport $sport
     * @return Evenement
     */
    public function setSport(\WS\OvsBundle\Entity\Sport $sport = null) {
        $this->sport = $sport;
        $sport->addEvenement($this);

        return $this;
    }

    /**
     * Get sport
     *
     * @return \WS\OvsBundle\Entity\Sport
     */
    public function getSport() {
        return $this->sport;
    }

    /**
     * Set date
     *
     * @param \WS\OvsBundle\Entity\Date $date
     * @return Evenement
     */
    public function setDate(\WS\OvsBundle\Entity\Date $date = null) {
        $this->date = $date;
        $date->addEvenement($this);

        return $this;
    }

    /**
     * Get date
     *
     * @return \WS\OvsBundle\Entity\Date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Add userEvenements
     *
     * @param \WS\OvsBundle\Entity\UserEvenement $userEvenements
     * @return Evenement
     */
    public function addUserEvenement(\WS\OvsBundle\Entity\UserEvenement $userEvenements) {
        $this->userEvenements[] = $userEvenements;

        return $this;
    }

    /**
     * Remove userEvenements
     *
     * @param \WS\OvsBundle\Entity\UserEvenement $userEvenements
     */
    public function removeUserEvenement(\WS\OvsBundle\Entity\UserEvenement $userEvenements) {
        $this->userEvenements->removeElement($userEvenements);
    }

    /**
     * Get userEvenements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserEvenements() {
        return $this->userEvenements;
    }

}

<?php

namespace WS\OvsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WS\OvsBundle\Entity\CommentaireRepository")
 */
class Commentaire {

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
     * @ORM\Column(name="contenue", type="text")
     * @Assert\NotBlank()
     *
     * Le contenue du commentaire.
     */
    private $contenue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     *
     * La date de création du commentaire.
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEdition", type="datetime", nullable=true)
     *
     * La date d'édition du commentaire.
     */
    private $dateEdition;

    /**
     * @var type
     *
     * @ORM\Column(name="actif", type="boolean")
     *
     * Le commentaire est actif(1) ou désactivé(0).
     */
    private $actif;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     *
     * L'utilisateur qui a créé le commentaire.
     */
    private $user;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="WS\OvsBundle\Entity\Evenement", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     *
     * l'évènement associer au commentaire.
     */
    private $evenement;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="commentaireEditions")
     * @ORM\JoinColumn(nullable=true)
     *
     * L'utilisateur qui a édité le commentaire.
     */
    private $userEdition;

    public function __construct() {
        $this->dateCreation = new \DateTime();

        $this->actif = 1;
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
     * Set contenue
     *
     * @param string $contenue
     * @return Commentaire
     */
    public function setContenue($contenue) {
        $this->contenue = $contenue;

        return $this;
    }

    /**
     * Get contenue
     *
     * @return string
     */
    public function getContenue() {
        return $this->contenue;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Commentaire
     */
    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation() {
        return $this->dateCreation;
    }

    /**
     * Set dateEdition
     *
     * @param \DateTime $dateEdition
     * @return Commentaire
     */
    public function setDateEdition($dateEdition) {
        $this->dateEdition = $dateEdition;

        return $this;
    }

    /**
     * Get dateEdition
     *
     * @return \DateTime
     */
    public function getDateEdition() {
        return $this->dateEdition;
    }

    /**
     * Set user
     *
     * @param \WS\UserBundle\Entity\User $user
     * @return Commentaire
     */
    public function setUser(\WS\UserBundle\Entity\User $user) {
        $this->user = $user;
        $user->addCommentaire($this);

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
     * @return Commentaire
     */
    public function setEvenement(\WS\OvsBundle\Entity\Evenement $evenement) {
        $this->evenement = $evenement;
        $evenement->addCommentaire($this);

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
     * Set userEdition
     *
     * @param \WS\UserBundle\Entity\User $userEdition
     * @return Commentaire
     */
    public function setUserEdition(\WS\UserBundle\Entity\User $userEdition = null) {
        $this->userEdition = $userEdition;
        $userEdition->addCommentaireEdition($this);

        return $this;
    }

    /**
     * Get userEdition
     *
     * @return \WS\UserBundle\Entity\User
     */
    public function getUserEdition() {
        return $this->userEdition;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     * @return Commentaire
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

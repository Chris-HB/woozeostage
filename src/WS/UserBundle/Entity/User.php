<?php

namespace WS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WS\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\OvsBundle\Entity\Evenement", mappedBy="user")
     */
    private $evenements;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\OvsBundle\Entity\UserEvenement", mappedBy="user")
     */
    private $userEvenements;

    /**
     * @ORM\OneToMany(targetEntity="WS\ChatBundle\Entity\Messagebox", mappedBy="emetteur")
     */
    private $emetteurs;

    /**
     * @ORM\OneToMany(targetEntity="WS\ChatBundle\Entity\Messagebox", mappedBy="recepteur")
     */
    private $recepteurs;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\OvsBundle\Entity\Commentaire", mappedBy="user")
     */
    private $commentaires;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\OvsBundle\Entity\Commentaire", mappedBy="userEdition")
     */
    private $commentaireEditions;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\OvsBundle\Entity\Evenement", mappedBy="userEdition")
     */
    private $evenementEditions;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\UserBundle\Entity\Ami", mappedBy="user")
     */
    private $amis;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\UserBundle\Entity\Ami", mappedBy="userbis")
     */
    private $amisbis;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userEvenements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emetteurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recepteurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaireEditions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evenementEditions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->amis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->amisbis = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add evenements
     *
     * @param \WS\OvsBundle\Entity\Evenement $evenements
     * @return User
     */
    public function addEvenement(\WS\OvsBundle\Entity\Evenement $evenements) {
        $this->evenements[] = $evenements;

        return $this;
    }

    /**
     * Remove evenements
     *
     * @param \WS\OvsBundle\Entity\Evenement $evenements
     */
    public function removeEvenement(\WS\OvsBundle\Entity\Evenement $evenements) {
        $this->evenements->removeElement($evenements);
    }

    /**
     * Get evenements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenements() {
        return $this->evenements;
    }

    /**
     * Add userEvenements
     *
     * @param \WS\OvsBundle\Entity\UserEvenement $userEvenements
     * @return User
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

    /**
     * Add emetteurs
     *
     * @param \WS\ChatBundle\Entity\Messagebox $emetteurs
     * @return User
     */
    public function addEmetteur(\WS\ChatBundle\Entity\Messagebox $emetteurs) {
        $this->emetteurs[] = $emetteurs;

        return $this;
    }

    /**
     * Remove emetteurs
     *
     * @param \WS\ChatBundle\Entity\Messagebox $emetteurs
     */
    public function removeEmetteur(\WS\ChatBundle\Entity\Messagebox $emetteurs) {
        $this->emetteurs->removeElement($emetteurs);
    }

    /**
     * Get emetteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmetteurs() {
        return $this->emetteurs;
    }

    /**
     * Add recepteurs
     *
     * @param \WS\ChatBundle\Entity\Messagebox $recepteurs
     * @return User
     */
    public function addRecepteur(\WS\ChatBundle\Entity\Messagebox $recepteurs) {
        $this->recepteurs[] = $recepteurs;

        return $this;
    }

    /**
     * Remove recepteurs
     *
     * @param \WS\ChatBundle\Entity\Messagebox $recepteurs
     */
    public function removeRecepteur(\WS\ChatBundle\Entity\Messagebox $recepteurs) {
        $this->recepteurs->removeElement($recepteurs);
    }

    /**
     * Get recepteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecepteurs() {
        return $this->recepteurs;
    }

    /**
     * Add commentaires
     *
     * @param \WS\OvsBundle\Entity\Commentaire $commentaires
     * @return User
     */
    public function addCommentaire(\WS\OvsBundle\Entity\Commentaire $commentaires) {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \WS\OvsBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\WS\OvsBundle\Entity\Commentaire $commentaires) {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires() {
        return $this->commentaires;
    }

    /**
     * Add commentaireEditions
     *
     * @param \WS\OvsBundle\Entity\Commentaire $commentaireEditions
     * @return User
     */
    public function addCommentaireEdition(\WS\OvsBundle\Entity\Commentaire $commentaireEditions) {
        $this->commentaireEditions[] = $commentaireEditions;

        return $this;
    }

    /**
     * Remove commentaireEditions
     *
     * @param \WS\OvsBundle\Entity\Commentaire $commentaireEditions
     */
    public function removeCommentaireEdition(\WS\OvsBundle\Entity\Commentaire $commentaireEditions) {
        $this->commentaireEditions->removeElement($commentaireEditions);
    }

    /**
     * Get commentaireEditions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaireEditions() {
        return $this->commentaireEditions;
    }

    /**
     * Add evenementEditions
     *
     * @param \WS\OvsBundle\Entity\Evenement $evenementEditions
     * @return User
     */
    public function addEvenementEdition(\WS\OvsBundle\Entity\Evenement $evenementEditions) {
        $this->evenementEditions[] = $evenementEditions;

        return $this;
    }

    /**
     * Remove evenementEditions
     *
     * @param \WS\OvsBundle\Entity\Evenement $evenementEditions
     */
    public function removeEvenementEdition(\WS\OvsBundle\Entity\Evenement $evenementEditions) {
        $this->evenementEditions->removeElement($evenementEditions);
    }

    /**
     * Get evenementEditions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenementEditions() {
        return $this->evenementEditions;
    }

    /**
     * Add amis
     *
     * @param \WS\UserBundle\Entity\Ami $amis
     * @return User
     */
    public function addAmi(\WS\UserBundle\Entity\Ami $amis) {
        $this->amis[] = $amis;

        return $this;
    }

    /**
     * Remove amis
     *
     * @param \WS\UserBundle\Entity\Ami $amis
     */
    public function removeAmi(\WS\UserBundle\Entity\Ami $amis) {
        $this->amis->removeElement($amis);
    }

    /**
     * Get amis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmis() {
        return $this->amis;
    }

    /**
     * Add amisbis
     *
     * @param \WS\UserBundle\Entity\Ami $amisbis
     * @return User
     */
    public function addAmisbi(\WS\UserBundle\Entity\Ami $amisbis) {
        $this->amisbis[] = $amisbis;

        return $this;
    }

    /**
     * Remove amisbis
     *
     * @param \WS\UserBundle\Entity\Ami $amisbis
     */
    public function removeAmisbi(\WS\UserBundle\Entity\Ami $amisbis) {
        $this->amisbis->removeElement($amisbis);
    }

    /**
     * Get amisbis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmisbis() {
        return $this->amisbis;
    }

}

<?php

namespace WS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

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
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
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

}

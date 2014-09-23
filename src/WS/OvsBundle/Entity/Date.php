<?php

namespace WS\OvsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Date
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WS\OvsBundle\Entity\DateRepository")
 * @UniqueEntity("date", message="Cette date existe déjà")
 */
class Date {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", unique=true)
     */
    private $date;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\OvsBundle\Entity\Evenement", mappedBy="date")
     */
    private $evenements;

    /**
     * Constructor
     */
    public function __construct() {
        $this->evenements = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Date
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Add evenements
     *
     * @param \WS\OvsBundle\Entity\Evenement $evenements
     * @return Date
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

}

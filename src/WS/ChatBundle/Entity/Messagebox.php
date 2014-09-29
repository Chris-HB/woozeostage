<?php

namespace WS\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messagebox
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WS\ChatBundle\Entity\MessageboxRepository")
 */
class Messagebox {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="emetteurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $emetteur;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="recepteurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recepteur;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * Constructor
     */
    public function __construct() {
        $this->date = new \DateTime();
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
     * Set message
     *
     * @param string $message
     * @return Messagebox
     */
    public function setMessage($message) {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Messagebox
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
     * Set emetteur
     *
     * @param \WS\UserBundle\Entity\User $emetteur
     * @return Messagebox
     */
    public function setEmetteur(\WS\UserBundle\Entity\User $emetteur) {
        $this->emetteur = $emetteur;
        $emetteur->addEmetteur($this);
        return $this;
    }

    /**
     * Get emetteur
     *
     * @return \WS\UserBundle\Entity\User
     */
    public function getEmetteur() {
        return $this->emetteur;
    }

    /**
     * Set recepteur
     *
     * @param \WS\UserBundle\Entity\User $recepteur
     * @return Messagebox
     */
    public function setRecepteur(\WS\UserBundle\Entity\User $recepteur) {
        $this->recepteur = $recepteur;
        $recepteur->addRecepteur($this);
        return $this;
    }

    /**
     * Get recepteur
     *
     * @return \WS\UserBundle\Entity\User
     */
    public function getRecepteur() {
        return $this->recepteur;
    }

}

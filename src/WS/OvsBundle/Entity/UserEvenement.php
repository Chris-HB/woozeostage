<?php

namespace WS\OvsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $user;

    /**
     * @var type
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="WS\OvsBundle\Entity\Evenement", inversedBy="userEvenements")
     */
    private $evenement;

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

}

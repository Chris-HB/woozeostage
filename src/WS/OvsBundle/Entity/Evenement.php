<?php

namespace WS\OvsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var type
     *
     * @ORM\Column(name="date", type="date")
     * @Assert\Date()
     *
     * La date de l'évènement.
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\Length(
     *      min="2",
     *      max="50",
     *      minMessage="Le nom doit faire au minimun {{ limit }} caractères",
     *      maxMessage="Le nom doit faire au maximun {{ limit }} caractères "
     * )
     *
     * Le nom de l'évènement.
     */
    private $nom;

    /**
     * @var type
     *
     * @ORM\Column(name="heure", type="time")
     * @Assert\Time()
     *
     * L'heure de l'évènement.
     */
    private $heure;

    /**
     * @var integer
     *
     * @ORM\Column(name="inscrit", type="integer")
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     *
     * Le nombre d'utilisateur maximal que l'évènement peut avoir.
     */
    private $inscrit;

    /**
     * @var type
     *
     * @ORM\Column(name="actif", type="boolean")
     *
     * L'évènement est actif(1) ou désactivé(0).
     */
    private $actif;

    /**
     * @ORM\Column(name="descriptif", type="text")
     * @Assert\NotBlank()
     *
     * Le déscriptif de l'évènement.
     */
    private $descriptif;

    /**
     * @var type
     *
     * @ORM\Column(name="adresse", type="text")
     * @Assert\NotBlank()
     *
     * L'adresse de l'évènement.
     */
    private $adresse;

    /**
     * @var type
     *
     * @ORM\Column(name="code_postal", type="text")
     * @Assert\Regex(
     * pattern="/((0[1-9])|([1-8][0-9])|(9[0-8])|(2A)|(2B))[0-9]{3}$/",
     * message="code postal non valide"
     * )
     *
     */
    private $codePostal;

    /**
     * @var type
     *
     * @ORM\Column(name="ville", type="text")
     * @Assert\NotBlank()
     */
    private $ville;

    /**
     * @var type
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var type
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var type @ORM\Column(name="type", type="string", length=255)
     *
     * Le type d'évènement : public ou privé.
     */
    private $type;

    /**
     * @var type
     *
     * @ORM\Column(name="nombrevalide", type="integer")
     *
     * Le nombre de personne avec le statut 1 (validé) pour l'évènement.
     */
    private $nombreValide;

    /**
     * @var type
     *
     * @ORM\Column(name="modification", type="text", nullable=true)
     *
     * La/les raison del a modification de l'évènement.
     */
    private $modification;

    /**
     * @var type
     *
     * @ORM\Column(name="date_creation", type="datetime")
     * @Assert\Date()
     */
    private $dateCreation;

    /**
     * @var type
     *
     * @ORM\Column(name="date_edition", type="datetime", nullable=true)
     * @Assert\Date()
     */
    private $dateEdition;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     *
     * L'utilisateur qui a créé l'évènement.
     */
    private $user;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="WS\OvsBundle\Entity\Sport", inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     *
     * Le sport associé a l'évènement.
     */
    private $sport;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\OvsBundle\Entity\UserEvenement", mappedBy="evenement")
     *
     * La liste des personnes inscriptent à l'évènement.
     */
    private $userEvenements;

    /**
     * @var type
     *
     * @ORM\OneToMany(targetEntity="WS\OvsBundle\Entity\Commentaire", mappedBy="evenement")
     *
     * La liste des commentaires associé à l'évènement.
     */
    private $commentaires;

    /**
     * @var type
     *
     * @ORM\ManyToOne(targetEntity="WS\UserBundle\Entity\User", inversedBy="evenementEditions")
     * @ORM\JoinColumn(nullable=true)
     */
    private $userEdition;

    /**
     * Constructor
     */
    public function __construct() {
        $this->date = new \DateTime();
        $this->actif = 1;
        $this->nombreValide = 0;
        $this->dateCreation = new \DateTime();
        $this->userEvenements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Evenement
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
     * Set heure
     *
     * @param \DateTime $heure
     * @return Evenement
     */
    public function setHeure($heure) {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return \DateTime
     */
    public function getHeure() {
        return $this->heure;
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
     * Set descriptif
     *
     * @param string $descriptif
     * @return Evenement
     */
    public function setDescriptif($descriptif) {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * Get descriptif
     *
     * @return string
     */
    public function getDescriptif() {
        return $this->descriptif;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Evenement
     */
    public function setAdresse($adresse) {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse() {
        return $this->adresse;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Evenement
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set nombreValide
     *
     * @param integer $nombreValide
     * @return Evenement
     */
    public function setNombreValide($nombreValide) {
        $this->nombreValide = $nombreValide;

        return $this;
    }

    /**
     * Get nombreValide
     *
     * @return integer
     */
    public function getNombreValide() {
        return $this->nombreValide;
    }

    /**
     * Set modification
     *
     * @param string $modification
     * @return Evenement
     */
    public function setModification($modification) {
        $this->modification = $modification;

        return $this;
    }

    /**
     * Get modification
     *
     * @return string
     */
    public function getModification() {
        return $this->modification;
    }

    /**
     * Set user
     *
     * @param \WS\UserBundle\Entity\User $user
     * @return Evenement
     */
    public function setUser(\WS\UserBundle\Entity\User $user) {
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
    public function setSport(\WS\OvsBundle\Entity\Sport $sport) {
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

    /**
     * Add commentaires
     *
     * @param \WS\OvsBundle\Entity\Commentaire $commentaires
     * @return Evenement
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
     * Set codePostal
     *
     * @param string $codePostal
     * @return Evenement
     */
    public function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal() {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Evenement
     */
    public function setVille($ville) {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille() {
        return $this->ville;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Evenement
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Evenement
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Evenement
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
     * @return Evenement
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
     * Set userEdition
     *
     * @param \WS\UserBundle\Entity\User $userEdition
     * @return Evenement
     */
    public function setUserEdition(\WS\UserBundle\Entity\User $userEdition = null) {
        $this->userEdition = $userEdition;
        $userEdition->addEvenementEdition($this);

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

}

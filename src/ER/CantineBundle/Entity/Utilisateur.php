<?php

namespace ER\CantineBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Utilisateur
 */
class Utilisateur {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var bool
     */
    private $actif=true;

    /**
     * @var string
     */
    private $nom;
    /**
     * @var int
     */
    private $total;
    /**
     * @var string
     */
    private $mail;

    /**
     * @var Collection
     */
    private $courses;
      
     /**
     * @var Collection 
     */
    private $repas;
    
    
   public function __construct() {
        $this->repas = new ArrayCollection();
        $this->courses = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return Utilisateur
     */
    public function setPass($pass) {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass() {
        return $this->pass;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Utilisateur
     */
    public function setActif($actif) {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return bool
     */
    public function getActif() {
        return $this->actif;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Utilisateur
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
     * Set mail
     *
     * @param string $mail
     *
     * @return Utilisateur
     */
    public function setMail($mail) {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail() {
        return $this->mail;
    }

    function getCourses() {
        return $this->courses;
    }

    function setCourses(Collection $courses) {
        $this->courses = $courses;
    }
    function getRepas() {
        return $this->repas;
    }

    function setRepas(Collection $repas) {
        $this->repas = $repas;
    }
    function getTotal() {
        return $this->total;
    }

    function setTotal($total) {
        $this->total = $total;
    }
}

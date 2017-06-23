<?php

namespace ER\CantineBundle\Entity;

/**
 * Course
 */
class Course {

    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $datecourse;

    /**
     * @var int
     */
    private $prix;

    /**
     *
     * @var Utilisateur
     */
    private $utilisateur;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    function getDatecourse() {
        return $this->datecourse;
    }

    function setDatecourse(\DateTime $datecourse) {
        $this->datecourse = $datecourse;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Course
     */
    public function setPrix($prix) {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix() {
        return $this->prix;
    }

    /**
     * Get utilisateur
     *
     * @return utilisateur
     */
    function getUtilisateur() {
        return $this->utilisateur;
    }

    /**
     * Set utilisateur
     *
     * @param Utilisateur $utilisateur
     *
     * @return Course
     */
    function setUtilisateur(Utilisateur $utilisateur) {
        $this->utilisateur = $utilisateur;
    }
}

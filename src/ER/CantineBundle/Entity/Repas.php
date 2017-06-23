<?php

namespace ER\CantineBundle\Entity;

/**
 * Repas
 */
class Repas {

    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $daterepas;

    /**
     * @var string
     */
    private $etat;

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

    function getDaterepas() {
        return $this->daterepas;
    }

    function setDaterepas(\DateTime $daterepas) {
        $this->daterepas = $daterepas;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Repas
     */
    public function setEtat($etat) {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat() {
        return $this->etat;
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
     * @return Repas
     */
    function setUtilisateur(Utilisateur $utilisateur) {
        $this->utilisateur = $utilisateur;
    }
}

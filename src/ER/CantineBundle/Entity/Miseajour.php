<?php

namespace ER\CantineBundle\Entity;

/**
 * Miseajour
 */
class Miseajour
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $datemaj;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datemaj
     *
     * @param \DateTime $datemaj
     *
     * @return Miseajour
     */
    public function setDatemaj($datemaj)
    {
        $this->datemaj = $datemaj;

        return $this;
    }

    /**
     * Get datemaj
     *
     * @return \DateTime
     */
    public function getDatemaj()
    {
        return $this->datemaj;
    }
}


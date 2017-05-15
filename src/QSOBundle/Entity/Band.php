<?php

namespace QSOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Band
 *
 * @ORM\Table(name="band")
 * @ORM\Entity(repositoryClass="QSOBundle\Repository\BandRepository")
 */
class Band
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="band", type="string", length=10, unique=true)
     */
    private $band;


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
     * Set band
     *
     * @param string $band
     *
     * @return Band
     */
    public function setBand($band)
    {
        $this->band = $band;

        return $this;
    }

    /**
     * Get band
     *
     * @return string
     */
    public function getBand()
    {
        return $this->band;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->band;
    }
}

<?php

namespace QSOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Callsign
 *
 * @ORM\Table(name="callsign")
 * @ORM\Entity(repositoryClass="QSOBundle\Repository\CallsignRepository")
 */
class Callsign
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
     * @ORM\Column(name="callsign", type="string", length=25, unique=true)
     */
    private $callsign;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * Callsign constructor.
     */
    public function __construct()
    {
        $this->isActive = false;
    }

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
     * Set callsign
     *
     * @param string $callsign
     *
     * @return Callsign
     */
    public function setCallsign($callsign)
    {
        $this->callsign = strtoupper($callsign);

        return $this;
    }

    /**
     * Get callsign
     *
     * @return string
     */
    public function getCallsign()
    {
        return $this->callsign;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Callsign
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}

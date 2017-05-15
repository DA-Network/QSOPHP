<?php

namespace QSOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FrequencyUnit
 *
 * @ORM\Table(name="frequency_unit")
 * @ORM\Entity(repositoryClass="QSOBundle\Repository\FrequencyUnitRepository")
 */
class FrequencyUnit
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
     * @ORM\Column(name="unit", type="string", length=5)
     */
    private $unit;


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
     * Set unit
     *
     * @param string $unit
     *
     * @return FrequencyUnit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->unit;
    }
}

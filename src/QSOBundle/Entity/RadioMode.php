<?php

namespace QSOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RadioMode
 *
 * @ORM\Table(name="radio_mode")
 * @ORM\Entity(repositoryClass="QSOBundle\Repository\RadioModeRepository")
 */
class RadioMode
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
     * @ORM\Column(name="mode", type="string", length=15)
     */
    private $mode;


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
     * Set mode
     *
     * @param string $mode
     *
     * @return RadioMode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->mode;
    }
}

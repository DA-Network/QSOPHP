<?php

namespace QSOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Logbook
 *
 * @ORM\Table(name="logbook")
 * @ORM\Entity(repositoryClass="QSOBundle\Repository\LogbookRepository")
 */
class Logbook
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
     * @ORM\ManyToOne(targetEntity="Callsign")
     */
    private $callsign;

    /**
     * @ORM\ManyToOne(targetEntity="FrequencyUnit")
     */
    private $frequencyUnit;

    /**
     * @ORM\ManyToOne(targetEntity="RadioMode")
     */
    private $radioMode;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="logbooks")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Band")
     */
    private $band;

    /**
     * @ORM\Column(name="frequency", type="decimal", precision=10, scale=3, nullable=false)
     */
    private $frequency;

    /**
     * @ORM\Column(name="rst_sent", type="integer", nullable=false)
     */
    private $rstSent;

    /**
     * @ORM\Column(name="rst_received", type="integer", nullable=false)
     */
    private $rstReceived;

    /**
     * @ORM\Column(name="power", type="integer", nullable=false)
     */
    private $power;

    /**
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(name="log_start", type="datetime", nullable=false)
     */
    private $logStart;

    /**
     * @ORM\Column(name="log_end", type="datetime", nullable=false)
     */
    private $logEnd;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * Logbook constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * @param \QSOBundle\Entity\Callsign $callsign
     *
     * @return Logbook
     */
    public function setCallsign(\QSOBundle\Entity\Callsign $callsign = null)
    {
        $this->callsign = $callsign;

        return $this;
    }

    /**
     * Get callsign
     *
     * @return \QSOBundle\Entity\Callsign
     */
    public function getCallsign()
    {
        return $this->callsign;
    }

    /**
     * Set frequencyUnit
     *
     * @param \QSOBundle\Entity\FrequencyUnit $frequencyUnit
     *
     * @return Logbook
     */
    public function setFrequencyUnit(\QSOBundle\Entity\FrequencyUnit $frequencyUnit = null)
    {
        $this->frequencyUnit = $frequencyUnit;

        return $this;
    }

    /**
     * Get frequencyUnit
     *
     * @return \QSOBundle\Entity\FrequencyUnit
     */
    public function getFrequencyUnit()
    {
        return $this->frequencyUnit;
    }

    /**
     * Set radioMode
     *
     * @param \QSOBundle\Entity\RadioMode $radioMode
     *
     * @return Logbook
     */
    public function setRadioMode(\QSOBundle\Entity\RadioMode $radioMode = null)
    {
        $this->radioMode = $radioMode;

        return $this;
    }

    /**
     * Get radioMode
     *
     * @return \QSOBundle\Entity\RadioMode
     */
    public function getRadioMode()
    {
        return $this->radioMode;
    }

    /**
     * Set user
     *
     * @param \QSOBundle\Entity\User $user
     *
     * @return Logbook
     */
    public function setUser(\QSOBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \QSOBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set frequency
     *
     * @param string $frequency
     *
     * @return Logbook
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set rstSent
     *
     * @param integer $rstSent
     *
     * @return Logbook
     */
    public function setRstSent($rstSent)
    {
        $this->rstSent = $rstSent;

        return $this;
    }

    /**
     * Get rstSent
     *
     * @return integer
     */
    public function getRstSent()
    {
        return $this->rstSent;
    }

    /**
     * Set rstReceived
     *
     * @param integer $rstReceived
     *
     * @return Logbook
     */
    public function setRstReceived($rstReceived)
    {
        $this->rstReceived = $rstReceived;

        return $this;
    }

    /**
     * Get rstReceived
     *
     * @return integer
     */
    public function getRstReceived()
    {
        return $this->rstReceived;
    }

    /**
     * Set power
     *
     * @param integer $power
     *
     * @return Logbook
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return integer
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Logbook
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set band
     *
     * @param \QSOBundle\Entity\Band $band
     *
     * @return Logbook
     */
    public function setBand(\QSOBundle\Entity\Band $band = null)
    {
        $this->band = $band;

        return $this;
    }

    /**
     * Get band
     *
     * @return \QSOBundle\Entity\Band
     */
    public function getBand()
    {
        return $this->band;
    }

    /**
     * Set logStart
     *
     * @param \DateTime $logStart
     *
     * @return Logbook
     */
    public function setLogStart($logStart)
    {
        $this->logStart = $logStart;

        return $this;
    }

    /**
     * Get logStart
     *
     * @return \DateTime
     */
    public function getLogStart()
    {
        return $this->logStart;
    }

    /**
     * Set logEnd
     *
     * @param \DateTime $logEnd
     *
     * @return Logbook
     */
    public function setLogEnd($logEnd)
    {
        $this->logEnd = $logEnd;

        return $this;
    }

    /**
     * Get logEnd
     *
     * @return \DateTime
     */
    public function getLogEnd()
    {
        return $this->logEnd;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Logbook
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

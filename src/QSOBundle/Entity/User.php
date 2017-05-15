<?php

namespace QSOBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="QSOBundle\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="email",
 *     message="This e-mail is already in use."
 * )
 */
class User implements UserInterface, \Serializable
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
     * @ORM\OneToMany(targetEntity="Logbook", mappedBy="user")
     */
    private $logbooks;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="firstname", type="string", length=45)
     */
    private $firstname;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="lastname", type="string", length=45)
     */
    private $lastname;

    /**
     * @Assert\NotBlank()
     */
    private $plainPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\Expression("this.getPlainPassword() == this.getPlainPasswordCompare()", message="The passwords should match")
     */
    private $plainPasswordCompare;

    /**
     * @Assert\Length(max=25, maxMessage="The Callsign cannot be longer than {{ limit }} characters")
     * @Assert\NotBlank()
     */
    private $callsignName;

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
     * @return User
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
     * Constructor
     */
    public function __construct()
    {
        $this->logbooks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add logbook
     *
     * @param \QSOBundle\Entity\Logbook $logbook
     *
     * @return User
     */
    public function addLogbook(\QSOBundle\Entity\Logbook $logbook)
    {
        $this->logbooks[] = $logbook;

        return $this;
    }

    /**
     * Remove logbook
     *
     * @param \QSOBundle\Entity\Logbook $logbook
     */
    public function removeLogbook(\QSOBundle\Entity\Logbook $logbook)
    {
        $this->logbooks->removeElement($logbook);
    }

    /**
     * Get logbooks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogbooks()
    {
        return $this->logbooks;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
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

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getPlainPasswordCompare()
    {
        return $this->plainPasswordCompare;
    }

    public function setPlainPasswordCompare($plainPasswordCompare)
    {
        $this->plainPasswordCompare = $plainPasswordCompare;
    }

    public function getCallsignName()
    {
        return $this->callsignName;
    }

    public function setCallsignName($callsignName)
    {
        return $this->callsignName = $callsignName;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}

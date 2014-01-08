<?php

namespace TUM\Ventureinitiative\GroupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @ORM\Entity(repositoryClass="TUM\Ventureinitiative\GroupBundle\Entity\Repository\ParticipantRepository")
 * @ORM\Table(name="vi_participant")
 *
 */

class Participant {

	/**
	 *
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO") 
	 *
	 */
	private $id;

	/**
	 *
	 * @ORM\Column(type="string", length=125)
	 *
	 */
	private $firstname;

	/**
	 *
	 * @ORM\Column(type="string", length=125)
	 *
	 */
	private $lastname;

	/**
	 *
	 * @ORM\Column(type="string", length=125)
	 *
	 */
	private $email;
	
	/**
	 *
	 * @ORM\Column(type="string", length=125, unique=true)
	 *
	 */
	private $auth_token;
	
	/**
	 * 
	 * @ORM\ManyToOne(targetEntity="Group", inversedBy="participants")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")
	 * 
	 */
	private $group;
	


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Participant
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
     * @return Participant
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

    /**
     * Set email
     *
     * @param string $email
     * @return Participant
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
     * Set auth_token
     *
     * @param string $authToken
     * @return Participant
     */
    public function setAuthToken($authToken)
    {
        $this->auth_token = $authToken;
    
        return $this;
    }

    /**
     * Get auth_token
     *
     * @return string 
     */
    public function getAuthToken()
    {
        return $this->auth_token;
    }

    /**
     * Set group
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\Group $group
     * @return Participant
     */
    public function setGroup(\TUM\Ventureinitiative\GroupBundle\Entity\Group $group = null)
    {
        $this->group = $group;
    
        return $this;
    }

    /**
     * Get group
     *
     * @return \TUM\Ventureinitiative\GroupBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }
}
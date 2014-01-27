<?php

namespace TUM\Ventureinitiative\GroupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @ORM\Entity
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
	protected $id;

	/**
	 *
	 * @ORM\Column(type="string", length=125, nullable=true)
	 *
	 */
	protected $firstname;

	/**
	 *
	 * @ORM\Column(type="string", length=125, nullable=true)
	 *
	 */
	protected $lastname;

	/**
	 *
	 * @ORM\Column(type="string", length=125, nullable=true)
	 *
	 */
	protected $email;
	
	/**
	 *
	 * @ORM\Column(type="string", length=125, unique=true)
	 *
	 */
	protected $auth_token;
	
	/**
	 * 
	 * @ORM\ManyToOne(targetEntity="Group", inversedBy="participants")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE")
	 * 
	 */
	protected $group;
	
	/**
	 *
	 * @ORM\OneToMany(targetEntity="GroupEvaluation", mappedBy="evaluating_participant")
	 *
	 */
	
	protected $evaluating;
	
	/**
	 *
	 * @ORM\OneToMany(targetEntity="GroupEvaluation", mappedBy="evaluated_participant")
	 *
	 */
	
	protected $evaluatedBy;
	
	/**
	 * 
	 * @ORM\Column(type="object", nullable=true)
	 *
	 */
	
	protected $result;


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

    /**
     * Set result
     *
     * @param \stdClass $result
     * @return Participant
     */
    public function setResult($result)
    {
        $this->result = $result;
    
        return $this;
    }

    /**
     * Get result
     *
     * @return \stdClass 
     */
    public function getResult()
    {
        return $this->result;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evaluating = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evaluatedBy = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add evaluating
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\GroupEvaluation $evaluating
     * @return Participant
     */
    public function addEvaluating(\TUM\Ventureinitiative\GroupBundle\Entity\GroupEvaluation $evaluating)
    {
        $this->evaluating[] = $evaluating;
    
        return $this;
    }

    /**
     * Remove evaluating
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\GroupEvaluation $evaluating
     */
    public function removeEvaluating(\TUM\Ventureinitiative\GroupBundle\Entity\GroupEvaluation $evaluating)
    {
        $this->evaluating->removeElement($evaluating);
    }

    /**
     * Get evaluating
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvaluating()
    {
        return $this->evaluating;
    }

    /**
     * Add evaluatedBy
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\GroupEvaluation $evaluatedBy
     * @return Participant
     */
    public function addEvaluatedBy(\TUM\Ventureinitiative\GroupBundle\Entity\GroupEvaluation $evaluatedBy)
    {
        $this->evaluatedBy[] = $evaluatedBy;
    
        return $this;
    }

    /**
     * Remove evaluatedBy
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\GroupEvaluation $evaluatedBy
     */
    public function removeEvaluatedBy(\TUM\Ventureinitiative\GroupBundle\Entity\GroupEvaluation $evaluatedBy)
    {
        $this->evaluatedBy->removeElement($evaluatedBy);
    }

    /**
     * Get evaluatedBy
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvaluatedBy()
    {
        return $this->evaluatedBy;
    }
}
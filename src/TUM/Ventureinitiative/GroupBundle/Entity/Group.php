<?php

namespace TUM\Ventureinitiative\GroupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;

/**
 *
 * @ORM\Entity(repositoryClass="TUM\Ventureinitiative\GroupBundle\Entity\Repository\GroupRepository")
 * @ORM\Table(name="vi_group")
 *
 */

class Group {
	
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
	 * @ORM\Column(type="string", length=125)
	 *
	 */
	protected $name;
	
	/**
	 *
	 * @ORM\Column(type="text", nullable=true)
	 *
	 */
	protected $description;
	
	/**
	 *
	 * @ORM\Column(type="integer")
	 *
	 */
	protected $status;
	
	/**
	 * 
	 * @ORM\ManyToOne(targetEntity="TUM\Ventureinitiative\TestBundle\Entity\Test")
     * @ORM\JoinColumn(name="test", referencedColumnName="id")
	 *
	 */
	protected $test;
	
	/**
	 *
	 * @ORM\Column(type="integer")
	 *
	 */
	protected $assignment_amount;
	
	/**
	 * 
	 * @ORM\OneToMany(targetEntity="Participant", mappedBy="group")
	 * 
	 */
	
	protected $participants;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set name
     *
     * @param string $name
     * @return Group
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Group
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Group
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set test
     *
     * @param \TUM\Ventureinitiative\TestBundle\Entity\Test $test
     * @return Group
     */
    public function setTest(\TUM\Ventureinitiative\TestBundle\Entity\Test $test = null)
    {
        $this->test = $test;
    
        return $this;
    }

    /**
     * Get test
     *
     * @return \TUM\Ventureinitiative\TestBundle\Entity\Test 
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Add participants
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\Participant $participants
     * @return Group
     */
    public function addParticipant(\TUM\Ventureinitiative\GroupBundle\Entity\Participant $participants)
    {
        $this->participants[] = $participants;
    
        return $this;
    }

    /**
     * Remove participants
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\Participant $participants
     */
    public function removeParticipant(\TUM\Ventureinitiative\GroupBundle\Entity\Participant $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set assignment_amount
     *
     * @param integer $assignmentAmount
     * @return Group
     */
    public function setAssignmentAmount($assignmentAmount)
    {
        $this->assignment_amount = $assignmentAmount;
    
        return $this;
    }

    /**
     * Get assignment_amount
     *
     * @return integer 
     */
    public function getAssignmentAmount()
    {
        return $this->assignment_amount;
    }
}
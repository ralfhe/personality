<?php

namespace TUM\Ventureinitiative\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * 
 * @ORM\Entity
 * @ORM\Table(name="vi_test")
 *
 */

class Test {
	
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
	protected $name;
	
	/**
	 *
	 * @ORM\Column(type="text", nullable=true)
	 *
	 */
	protected $description;
	
	/**
	 *
	 * @ORM\Column(type="string", length=200, unique=true)
	 *
	 */
	protected $type;
	
	/**
	 *
	 * @ORM\Column(type="integer")
	 *
	 */
	protected $status;
	
	/**
	 *
	 * @ORM\Column(type="string", length=125)
	 *
	 */
	protected $version;
	
	/**
	 *
	 * @ORM\OneToMany(targetEntity="TUM\Ventureinitiative\GroupBundle\Entity\Group", mappedBy="test")
	 *
	 */
	protected $groups;
	
	public function getNameAndVersion() {
		
		return $this->name.' (v.'.$this->version.')';
		
	}

	
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Test
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
     * @return Test
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
     * Set type
     *
     * @param string $type
     * @return Test
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Test
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
     * Set version
     *
     * @param string $version
     * @return Test
     */
    public function setVersion($version)
    {
        $this->version = $version;
    
        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Add groups
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\Group $groups
     * @return Test
     */
    public function addGroup(\TUM\Ventureinitiative\GroupBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    
        return $this;
    }

    /**
     * Remove groups
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\Group $groups
     */
    public function removeGroup(\TUM\Ventureinitiative\GroupBundle\Entity\Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
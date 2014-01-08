<?php

namespace TUM\Ventureinitiative\StudentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="TUM\Ventureinitiative\StudentBundle\Entity\StudentRepository")
 * @ORM\Table(name="student")
 *
 */

class Student {
	
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
     * @return Student
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
     * @return Student
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
     * @return Student
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
}
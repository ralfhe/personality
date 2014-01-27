<?php

namespace TUM\Ventureinitiative\GroupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="vi_group_evaluation")
 *
 */

class GroupEvaluation {
	
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
	 * @ORM\ManyToOne(targetEntity="TUM\Ventureinitiative\GroupBundle\Entity\Participant")
     * @ORM\JoinColumn(name="evaluating_participant", referencedColumnName="id", onDelete="CASCADE")
	 *
	 */
	protected $evaluating_participant;
	
	/**
	 *
	 * @ORM\ManyToOne(targetEntity="TUM\Ventureinitiative\GroupBundle\Entity\Participant")
     * @ORM\JoinColumn(name="evaluated_participant", referencedColumnName="id", onDelete="CASCADE")
	 *
	 */
	protected $evaluated_participant;
	
	/**
	 *
	 * @ORM\Column(type="array", nullable=true)
	 *
	 */
	protected $form_data;
	
	/**
	 * 
	 * @ORM\Column(type="array", nullable=true)
	 *
	 */
	protected $evaluation;


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
     * Set result
     *
     * @param array $result
     * @return GroupEvaluation
     */
    public function setResult($result)
    {
        $this->result = $result;
    
        return $this;
    }

    /**
     * Get result
     *
     * @return array 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set evaluating_participant
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\Participant $evaluatingParticipant
     * @return GroupEvaluation
     */
    public function setEvaluatingParticipant(\TUM\Ventureinitiative\GroupBundle\Entity\Participant $evaluatingParticipant = null)
    {
        $this->evaluating_participant = $evaluatingParticipant;
    
        return $this;
    }

    /**
     * Get evaluating_participant
     *
     * @return \TUM\Ventureinitiative\GroupBundle\Entity\Participant 
     */
    public function getEvaluatingParticipant()
    {
        return $this->evaluating_participant;
    }

    /**
     * Set evaluated_participant
     *
     * @param \TUM\Ventureinitiative\GroupBundle\Entity\Participant $evaluatedParticipant
     * @return GroupEvaluation
     */
    public function setEvaluatedParticipant(\TUM\Ventureinitiative\GroupBundle\Entity\Participant $evaluatedParticipant = null)
    {
        $this->evaluated_participant = $evaluatedParticipant;
    
        return $this;
    }

    /**
     * Get evaluated_participant
     *
     * @return \TUM\Ventureinitiative\GroupBundle\Entity\Participant 
     */
    public function getEvaluatedParticipant()
    {
        return $this->evaluated_participant;
    }

    /**
     * Set evaluation
     *
     * @param array $evaluation
     * @return GroupEvaluation
     */
    public function setEvaluation($evaluation)
    {
        $this->evaluation = $evaluation;
    
        return $this;
    }

    /**
     * Get evaluation
     *
     * @return array 
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * Set form_data
     *
     * @param array $formData
     * @return GroupEvaluation
     */
    public function setFormData($formData)
    {
        $this->form_data = $formData;
    
        return $this;
    }

    /**
     * Get form_data
     *
     * @return array 
     */
    public function getFormData()
    {
        return $this->form_data;
    }
}
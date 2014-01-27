<?php

namespace TUM\Ventureinitiative\TestBundle\Entity;

class Wizard {
	
	private $assignedParticipant;
	private $groupEvaluation;

	public function getAssignedParticipant() {
		return $this->assignedParticipant;
	}
	
	public function setAssignedParticipant($assignedParticipant) {
		$this->assignedParticipant = $assignedParticipant;
		return $this;
	}
	
	public function getGroupEvaluation() {
		return $this->groupEvaluation;
	}
	
	public function setGroupEvaluation($groupEvaluation) {
		$this->groupEvaluation = $groupEvaluation;
		return $this;
	}
	
}
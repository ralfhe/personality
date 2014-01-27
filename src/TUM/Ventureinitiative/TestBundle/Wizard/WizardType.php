<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class WizardType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
		$builder->add('assignedParticipant', 'hidden')
				->add('groupEvaluation', 'hidden');
		
	}
	
	public function getName() {
		return "Wizard";
	}
	
}
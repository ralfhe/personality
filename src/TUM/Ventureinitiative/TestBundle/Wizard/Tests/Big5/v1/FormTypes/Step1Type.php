<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\v1\FormTypes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TUM\Ventureinitiative\TestBundle\Wizard\WizardType;

class Step1Type extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
	
		$questions = array(
				'Is talkative',
				'Tends to find fault with others',
				'Does a thorough job',
				'Is depressed, blue',
				'Is original, comes up with new ideas',
				'Is reserved',
				'Is helpful and unselfish with others',
				'Can be somewhat careless',
				'Is relaxed, handles stress well',
				'Is curious about many different things',
				'Is full of energy',
				'Starts quarrels with others',
				'Is a reliable worker',
				'Can be tense',
				'Is ingenious, a deep thinker',
				'Generates a lot of enthusiasm',
				'Has a forgiving nature',
				'Tends to be disorganized',
				'Worries a lot',
				'Has an active imagination',
				'Tends to be quiet',
				'Is generally trusting',
				'Tends to be lazy');
		
		foreach($questions as $key=>$question) {

			$builder->add('question_'.$key,'choice', array(
					'choices'   => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5),
    				'expanded'  => true, 
					'multiple' 	=> false,
					'label' 	=> $question));
		}

	}

	
	public function getName() {
		return 'Step1';
	}

	
}
<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\v1\FormTypes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TUM\Ventureinitiative\TestBundle\Wizard\WizardType;

class Step2Type extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
	
		$questions = array(
				'Is emotionally stable, not easily upset',
				'Is inventive',
				'Has an assertive personality',
				'Can be cold and aloof',
				'Perseveres until the task is finished',
				'Can be moody',
				'Values artistic, aesthetic experiences',
				'Is sometimes shy, inhibited',
				'Is considerate and kind to almost everyone',
				'Does things efficiently',
				'Remains calm in tense situations',
				'Prefers work that is routine',
				'Is outgoing, sociable',
				'Is sometimes rude to others',
				'Makes plans and follows through with them',
				'Gets nervous easily',
				'Likes to reflect, play with ideas',
				'Has few artistic interests',
				'Likes to cooperate with others',
				'Is easily distracted',
				'Is sophisticated in art, music, or literature');
		
		foreach($questions as $key=>$question) {

			$builder->add('question_'.$key,'choice', array(
					'choices'   => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5),
    				'expanded'  => true, 
					'multiple' 	=> false,
					'label' 	=> $question));
		}

	}

	
	public function getName() {
		return 'Step2';
	}

	
}
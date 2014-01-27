<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\v1\FormTypes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class UniqueStep1Type extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
	
		$builder->add('age', 'number', array('constraints' => array(new GreaterThanOrEqual(array('value' => 21)), new LessThanOrEqual(array('value' => 60)))));

	}

	
	public function getName() {
		return 'UniqueStep';
	}

	
}
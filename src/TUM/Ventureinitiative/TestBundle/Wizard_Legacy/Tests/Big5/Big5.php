<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5;

use TUM\Ventureinitiative\TestBundle\Wizard\TestInterface;
use TUM\Ventureinitiative\TestBundle\Wizard\GenericStep;

class Big5 implements TestInterface {
	
	private $name = "Big Five Personality Test";
	private $description = "This personality test is based on the Big Five personality traits and covers openness, conscientiousness, extraversion, agreeableness, and neuroticism.";
	private $resultView = null;
	private $steps = array();
	private $stepsOnce = array();
	
	public function __construct() {
		
		for($i = 1; class_exists('TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\FormTypes\Step'.$i.'Type'); $i++) {
			$stepFormType = 'TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\FormTypes\Step'.$i.'Type';
			$step = new GenericStep();
			$step->setFormType(new $stepFormType);
			$step->setName('Step '.$i);
			$step->setTemplate('@test_view\Big5\Views\step.html.twig');
			$this->steps[] = $step;
		}
		
		for($i = 1; class_exists('TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\FormTypes\StepOnce'.$i.'Type'); $i++) {
			$stepFormType = 'TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\FormTypes\StepOnce'.$i.'Type';
			$step = new GenericStep();
			$step->setFormType(new $stepFormType);
			$step->setName('Step '.$i);
			$step->setTemplate('@test_view\Big5\Views\step.html.twig');
			$this->stepsOnce[] = $step;
		}
		
	}
	
	public function getSteps() {
		return $this->steps;
	}
	
	public function getStepsOnce() {
		return $this->stepsOnce;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getDescription() {
		return $this->description;
	}

	public function evaluate($answers) {
		
	}
	
	public function getResultView() {
		return $this->resultView;
	}
	
}
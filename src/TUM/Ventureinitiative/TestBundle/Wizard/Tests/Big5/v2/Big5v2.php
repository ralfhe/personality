<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard\Tests\Big5\v2;

use TUM\Ventureinitiative\TestBundle\Wizard\TestInterface;
use TUM\Ventureinitiative\TestBundle\Wizard\GenericStep;
use TUM\Ventureinitiative\TestBundle\TUMVentureinitiativeTestBundle;

class Big5v2 implements TestInterface {
	
	private $resultView = null;
	private $steps;
	private $stepCount;
	
	public function getSteps() {
		return $this->steps;
	}
	
	public function getStepCount() {
		return $this->stepCount;
	}
	
	public function evaluate($formData) {
		
	}
	
	public function calculateResult($data) {
		
	}
	
	public function getResultView() {
		return $this->resultView;
	}

	
}
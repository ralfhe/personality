<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard;

interface TestInterface {
	
	public function getSteps();
	public function getStepCount();
	public function evaluate($formData);
	public function calculateResult($data);
	public function getResultView();
	
}
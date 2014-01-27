<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard;

interface TestInterface {
	
	public function getName();
	public function getDescription();
	public function getSteps();
	public function getStepsOnce();
	public function evaluate($answers);
	public function getResultView();
	
}
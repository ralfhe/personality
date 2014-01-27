<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard;

interface StepInterface {
	
	public function getName();
	public function getView();
	public function getFormType();
	public function isUnique();
	
}

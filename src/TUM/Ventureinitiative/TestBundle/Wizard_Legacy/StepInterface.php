<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard;

interface StepInterface {
	
	public function getName();
	public function getFormType();
	public function getTemplate();
	
	public function setName($name);
	public function setFormType($formType);
	public function setTemplate($template);
	
}

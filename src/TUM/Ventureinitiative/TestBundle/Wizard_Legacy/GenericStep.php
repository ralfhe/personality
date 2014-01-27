<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard;

use TUM\Ventureinitiative\TestBundle\Wizard\StepInterface;

class GenericStep implements StepInterface {
	
	private $formType;
	private $name;
	private $template;
	
	public function setFormType($formType) {
		$this->formType = $formType;
	}
	
	public function getFormType() {
		return $this->formType;
	}

	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}

	public function setTemplate($template) {
		$this->template = $template;
	}

	public function getTemplate() {
		return $this->template;
	}

}
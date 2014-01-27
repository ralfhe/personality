<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard;

use TUM\Ventureinitiative\TestBundle\Wizard\StepInterface;

class GenericStep implements StepInterface {
	
	private $name;
	private $view;
	private $formType;
	private $unique;
	
	public function __construct($name, $view, $formType, $unique) {
		$this->name = $name;
		$this->view = $view;
		$this->formType = $formType;
		$this->unique = $unique;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}

	public function setView($view) {
		$this->view = $view;
	}

	public function getView() {
		return $this->view;
	}
	
	public function setFormType($formType) {
		$this->formType = $formType;
	}
	
	public function getFormType() {
		return $this->formType;
	}
	
	public function isUnique() {
		return $this->unique;
	}
	
	public function setUnique($unique) {
		$this->unique = $unique;
	}

}
<?php

namespace TUM\Ventureinitiative\TestBundle\Wizard;

class StepCount {
	
	private $current;
	private $rounds;
	private $total;
	private $steps;
	private $stepsOnce;

	public function __construct($steps, $stepsOnce, $current = 1, $rounds = 1) {
		$this->steps = $steps;
		$this->stepsOnce = $stepsOnce;
		$this->setCurrent($current);
		$this->setRounds($rounds);
		$this->setTotal();
	}
	
	public function getCurrent() {
		return $this->current;
	}
	
	public function setCurrent($current) {
		$this->current = $current;
		return $this;
	}
	
	public function getRounds() {
		return $this->rounds;
	}
	
	public function setRounds($rounds) {
		$this->rounds = $rounds;
		$this->setTotal();
		return $this;
	}
	
	public function getTotal() {
		return $this->total;
	}
	
	private function setTotal() {
		$this->total = $this->steps * $this->rounds + $this->stepsOnce;
		return $this;
	}

	public function getSteps() {
		return $this->steps;
	}
	
	public function setSteps($steps) {
		$this->steps = $steps;
		return $this;
	}
	
	public function getStepsOnce() {
		return $this->stepsOnce;
	}
	
	public function setStepsOnce($stepsOnce) {
		$this->stepsOnce = $stepsOnce;
		return $this;
	}
	
}
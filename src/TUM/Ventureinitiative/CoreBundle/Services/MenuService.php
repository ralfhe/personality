<?php

namespace TUM\Ventureinitiative\CoreBundle\Services;

use TUM\Ventureinitiative\CoreBundle\Interfaces\MenuServiceInterface;

class MenuService implements MenuServiceInterface {
	
	private $name;
	private $options;
	
	public function __construct() {
		
		$this->name = 'Home';
		$this->options = array('route' => 'core_homepage');
		
	}
	
	public function getInformation() {
		
		return array("name" => $this->name, "options" => $this->options);
		
	}
	
}
 
?>
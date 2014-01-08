<?php

namespace TUM\Ventureinitiative\CoreBundle\Services;

class MainMenuService {
	
	private $mainMenuItems;
	
	public function __construct() {
		
		$this->mainMenuItems = array();
		
	}
	
	public function registerBundle($name, $path) {
		
		$this->mainMenuItems[] = array('name' => $name, 'path' => $path); 
		
	}
	
	public function retrieveItems() {
		
		return $mainMenuItems;
		
	}
	
}

?>
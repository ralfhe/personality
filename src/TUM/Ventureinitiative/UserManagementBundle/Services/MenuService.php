<?php

namespace TUM\Ventureinitiative\UserManagementBundle\Services;

use TUM\Ventureinitiative\CoreBundle\Interfaces\MenuServiceInterface;

class MenuService implements MenuServiceInterface {
	
	private $name;
	private $options;
	
	public function __construct() {
		
		$this->name = 'User Management';
		$this->options = array('route' => 'user_management_homepage');
		
	}
	
	public function getInformation() {
		
		return array("name" => $this->name, "options" => $this->options);
		
	}
	
}
 
?>
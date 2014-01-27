<?php

namespace TUM\Ventureinitiative\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use TUM\Ventureinitiative\CoreBundle\Interfaces\MenuServiceInterface;

class MenuBuilder {
	
	private $factory;
	private $mainMenuItems;
	
	public function __construct(FactoryInterface $factory) {
		
		$this->factory = $factory;
		$this->mainMenuItems = array();
		
	} 
		
	public function createMainMenu(Request $request, array $menuInfo) {
		
		$menu = $this->factory->createItem('root');
		
		$menu->setChildrenAttribute('class', 'nav navbar-nav');
		
// 		foreach ($this->mainMenuItems as $menuItem) {
			
// 			$menu->addChild($menuItem['name'], $menuItem['options']);
			
// 		}

//		$menu->addChild('Dashboard', array('route' => 'backend_index'));
		$menu->addChild('Groups', array('route' => 'tum_ventureinitiative_group_index'));
		$menu->addChild('Tests', array('route' => 'tum_ventureinitiative_admin_test_management_overview'));
		$menu->addChild('Settings', array('route' => 'core_backend_settings_index'));
		
		return $menu;
		
	}
	
	public function registerMainMenuItem(MenuServiceInterface $service) {
		
		$this->mainMenuItems[] = $service->getInformation(); 
		
	}
	
}

?>
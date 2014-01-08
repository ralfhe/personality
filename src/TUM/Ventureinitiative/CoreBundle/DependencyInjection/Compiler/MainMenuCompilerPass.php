<?php

namespace TUM\Ventureinitiative\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class MainMenuCompilerPass implements CompilerPassInterface {
	
	public function process(ContainerBuilder $container) {
		
		if(!$container->hasDefinition('tum_ventureinitiative_core.menu_builder')) {
			return;
		}
		
		$definition = $container->getDefinition('tum_ventureinitiative_core.menu_builder');
		
		$taggedServices = $container->findTaggedServiceIds('tum_ventureinitiative_core.main_menu');
		
		foreach($taggedServices as $id => $attributes) {
			
			$definition->addMethodCall('registerMainMenuItem', array(new Reference($id)));
			
		}
		
	}
	
}

?>
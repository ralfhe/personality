<?php

namespace TUM\Ventureinitiative\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TUM\Ventureinitiative\CoreBundle\DependencyInjection\Compiler\MainMenuCompilerPass;

class CoreBundle extends Bundle {
	
	public function build(ContainerBuilder $container) {
		
		parent::build($container);
		
		$container->addCompilerPass(new MainMenuCompilerPass());
		
	}
}

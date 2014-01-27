<?php

namespace TUM\Ventureinitiative\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RegistrationFormType extends BaseType
{
	private $container;
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);

		var_dump($this->container->getParameter('security.role_hierarchy.roles'));
		
		$builder->add('lastname')
				->add('firstname')
				->add('roles', 'choice', array('choices' => $this->container->getParameter('security.role_hierarchy.roles')));
		
	}

	public function getName()
	{
		return 'core_user_registration';
	}
	
	public function setContainer(ContainerInterface $container) {
		$this->container = $container;
	}
}

?>
<?php

namespace TUM\Ventureinitiative\UserManagementBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {

		$builder->add('firstname', 'text')
    		->add('lastname', 'text')
    		->add('email', 'email');

	}
	
	public function getName() {
		
		return 'user';
		
	}
	
}
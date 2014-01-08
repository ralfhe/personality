<?php

namespace TUM\Ventureinitiative\UserManagementBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {

		$builder->add('file', 'file')
    		->add('separator', 'text');

	}
	
	public function getName() {
		
		return 'userCSV';
		
	}
	
}
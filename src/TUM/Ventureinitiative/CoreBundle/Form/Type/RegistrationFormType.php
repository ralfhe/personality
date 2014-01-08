<?php

namespace TUM\Ventureinitiative\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);

		$builder->add('lastname')->add('firstname');
		
	}

	public function getName()
	{
		return 'core_user_registration';
	}
}

?>
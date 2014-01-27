<?php

namespace TUM\Ventureinitiative\GroupBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TUM\Ventureinitiative\TestBundle\Entity\Test;

class GroupType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {

		$builder->add('name', 'text')
		->add('description', 'textarea')
		->add('assignmentAmount', 'number')
		->add('test', 'entity', array(
			'class' => 'TUMVentureinitiativeTestBundle:Test',
			'property' => 'nameAndVersion'
			))
		->add('status', 'hidden', array(
			'data' => 0
		))
		->add('createAndFinish', 'submit')
		->add('createAndAddUsers', 'submit');

	}

	public function getName() {

		return 'group';

	}

}
<?php

namespace TUM\Ventureinitiative\TestBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TestType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {

		$builder->add('name', 'text')
		->add('description', 'textarea')
		->add('submit', 'submit');

	}

	public function getName() {

		return 'test';

	}

}
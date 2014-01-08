<?php

namespace TUM\Ventureinitiative\StudentBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\DependencyInjection\ContainerAware;


class StudentService extends ContainerAware {
		
	public function listStudents($page = 1, $entries = 10) {
		
		$repository = $this->container->get('doctrine')->getRepository('TUMVentureinitiativeStudentBundle:Student');
		 
		return $repository->listStudents($page, $entries);
		
	}
	
	public function searchStudents($query) {
		
		$repository = $this->container->get('doctrine')->getRepository('TUMVentureinitiativeStudentBundle:Student');

		return $repository->searchStudents($query);
		
	}
	
}
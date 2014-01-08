<?php

namespace TUM\Ventureinitiative\StudentBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use TUM\Ventureinitiative\StudentBundle\TUMVentureinitiativeStudentBundle;


class StudentRepository extends EntityRepository {

	public function listStudents($page = 1, $entries = 10) {
		
		$dqlPaging = "SELECT s FROM TUMVentureinitiativeStudentBundle:Student s";
		
		$page--;
		
		$query = $this->getEntityManager()
			->createQuery($dqlPaging)
			->setFirstResult($page * $entries)
			->setMaxResults($entries);
		
		$paginator = new Paginator($query, $fetchJoinCollection = true);
		
		$students = array();
		
		foreach($paginator as $student) {
			
			$students[] = $student;
			
		}
		
		$pageCount = ceil(count($this->getEntityManager()->getRepository('TUMVentureinitiativeStudentBundle:Student')->findAll()) / $entries);
		
		return array('students' => $students, 'pageCount' => $pageCount); 
		
	}
	
	public function searchStudents($query, $page = 1, $entries = 10) {
		
		$queryParts = explode(' ', $query);
	
		$queryBuilder = $this->createQueryBuilder('s');
		
		$result = array();
		
		foreach($queryParts as $qpKey => $qpValue) {
		
			$queryBuilder->where('s.firstname LIKE :qp OR s.lastname LIKE :qp OR s.email LIKE :qp')
			->setParameter('qp', '%'.$qpValue.'%');
		
			$result[] = $queryBuilder->getQuery()->getResult();
		
		}
		
		$query = $this->getEntityManager()
			->createQuery('SELECT COUNT(s) FROM TUMVentureinitiativeStudentBundle:Student s');
		
		$pageCount = ceil(($query->getResult()[0][1]) / $entries);
		
		return array('students' => $result, 'pageCount' => $pageCount);
		
	}
	
	private function paging() {
		
		$page--;
		
		$query = $this->getEntityManager()
		->createQuery($dqlPaging)
		->setFirstResult($page * $entries)
		->setMaxResults($entries);
		
		$paginator = new Paginator($query, $fetchJoinCollection = true);
		
		$students = array();
		
		foreach($paginator as $student) {
				
			$students[] = $student;
				
		}
		
		$pageCount = ceil(count($this->getEntityManager()->getRepository('TUMVentureinitiativeStudentBundle:Student')->findAll()) / $entries);
		
		return array('students' => $students, 'pageCount' => $pageCount);
		
	}
	
}

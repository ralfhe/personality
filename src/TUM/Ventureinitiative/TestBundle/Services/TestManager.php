<?php

namespace TUM\Ventureinitiative\TestBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use TUM\Ventureinitiative\TestBundle\Entity\Test;

class TestManager {
	
	const TEST_DIR = '../src/TUM/Ventureinitiative/TestBundle/Wizard/Tests/';
	const TEST_INTERFACE = 'TUM\Ventureinitiative\TestBundle\Wizard\TestInterface';
	
	private $testsOnDisk;
	private $container;
	
	public function __construct() {
	
	}
	
	private function fetchExistingTestsFromDisk() {
		
		$directory = new \RecursiveDirectoryIterator(self::TEST_DIR);
		$iterator = new \RecursiveIteratorIterator($directory);
		$phpFiles = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);
		
		foreach ($phpFiles as $file) {
			
			$className = strtr(substr($file[0], strpos($file[0], 'TUM'), -4), "/", "\\");
			
			if(class_exists($className) && in_array(self::TEST_INTERFACE, class_implements($className))) {
				$this->testsOnDisk[] = $className;
			}
		}
		
	}
	
	private function syncTestsOnDiskWithDatabase() {
		
		$this->fetchExistingTestsFromDisk();
		
		$em = $this->container->get('doctrine')->getManager();
		$testRepository = $em->getRepository('TUMVentureinitiativeTestBundle:Test');
		$persistedTests = $testRepository->findAll();
		$persistedTestTypes = array();
		
		foreach($persistedTests as $persistedTest) {
			$persistedTestTypes[] = $persistedTest->getType();
		}
		
		foreach ($this->testsOnDisk as $testOnDisk) {
			
			if(!in_array($testOnDisk, $persistedTestTypes)){
				$newTest = new Test();
				$newTest->setType($testOnDisk);
				$newTest->setStatus(0);
				$newTest->setVersion($this->getTestVersion($testOnDisk));
				$em->persist($newTest);
			}
		}
		
		$em->flush();
		
	}
	
	private function getTestVersion($testType) {
		
		return substr(substr($testType, strrpos($testType, '\\')), strpos(substr($testType, strrpos($testType, '\\')), 'v') + 1);
		
	}
	
	public function getTestRecords() {
		
		$this->syncTestsOnDiskWithDatabase();
		
		$em = $this->container->get('doctrine')->getManager();
		$testRepository = $em->getRepository('TUMVentureinitiativeTestBundle:Test');
		return $testRepository->findAll();
				
	}
	
	public function changeStatus($testId) {
		
		$em = $this->container->get('doctrine')->getManager();
		$testRepository = $em->getRepository('TUMVentureinitiativeTestBundle:Test');
		$test = $testRepository->findOneById($testId);
		$status = $test->getStatus();
		$test->setStatus(++$status);
		$em->flush();
				
	}

	public function setContainer(ContainerInterface $container) {
		$this->container = $container;
	}
	
	
}
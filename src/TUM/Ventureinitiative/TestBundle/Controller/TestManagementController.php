<?php

namespace TUM\Ventureinitiative\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TUM\Ventureinitiative\TestBundle\Form\Type\TestType;

class TestManagementController extends Controller {
	
	public function testAction() {
		
		$this->get('tum_ventureinitiative_test.test_manager')->syncTestsOnDiskWithDatabase();
		
		$response = new Response('Hello');
		
		return $response;
		
	}
	
	public function overviewAction() {
		
		$testManager = $this->get('tum_ventureinitiative_test.test_manager');
		$persistedTests = $testManager->getTestRecords();
		
		return $this->render('TUMVentureinitiativeTestBundle:TestManagement:overview.html.twig', array('tests' => $persistedTests));
			
	}
	
	public function changeStatusAction($testId) {
		
		$this->get('tum_ventureinitiative_test.test_manager')->changeStatus($testId);
		
		return $this->redirect($this->generateUrl('tum_ventureinitiative_admin_test_management_overview'));
		
	}
	
	public function editTestAction($testId, Request $request) {
		
		$repository = $this->getDoctrine()->getRepository('TUMVentureinitiativeTestBundle:Test');
		$test = $repository->findOneById($testId);
		 
		$testForm = $this->createForm(new TestType(), $test);
		$testForm->handleRequest($request);
		
		if($testForm->isValid()) {
			 
			$em = $this->getDoctrine()->getManager();
			$em->flush();
			 
			return $this->redirect($this->generateUrl('tum_ventureinitiative_admin_test_management_overview'));
		
		}

		return $this->render('TUMVentureinitiativeTestBundle:TestManagement:testForm.html.twig', array('testForm' => $testForm->createView()));
		
	}
	
}
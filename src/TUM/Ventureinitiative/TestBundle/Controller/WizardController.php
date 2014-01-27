<?php

namespace TUM\Ventureinitiative\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\Request;
use TUM\Ventureinitiative\TestBundle\Wizard\StepCount;
use TUM\Ventureinitiative\TestBundle\Wizard\WizardType;
use TUM\Ventureinitiative\TestBundle\Entity\Wizard;
use FOS\UserBundle\Util\TokenGenerator;
use Symfony\Component\HttpFoundation\Response;


class WizardController extends Controller {
	
	public function singleAction($testId, $step, Request $request) {

		$em = $this->getDoctrine()->getManager();
		$testRepository = $em->getRepository('TUMVentureinitiativeTestBundle:Test');
		$testRecord = $testRepository->findOneById($testId);

		$testType = $testRecord->getType();
		$test = new $testType;
		$steps = $test->getSteps();
		$stepCount = $test->getStepCount();
		$session = $request->getSession();
		
		if($step >= 1 && $step <= $stepCount['total']) {
			
			$currentStep = $steps[$step - 1];
			
			$form = $this->createForm($currentStep->getFormType());
			
			if($step <= $stepCount['steps']) {
				if(!$formData = $session->get('formData')) {
					$formData = array();
				}
				else if (isset($formData[$step - 1])){
					$form->setData($formData[$step - 1]);
				}
			}
			else {
				if(!$uniqueFormData = $session->get('uniqueFormData')) {
					$uniqueFormData = array();
				}
				else if (isset($uniqueFormData[$step - $stepCount['steps'] - 1])){
					$form->setData($uniqueFormData[$step - $stepCount['steps'] - 1]);
				}
			}
			
			$form->handleRequest($request);
			
			if($form->isValid())
			{
				if($step <= $stepCount['steps']) {
					$formData[$step - 1] = $form->getData();
					$session->set('formData', $formData);
				}
				else {
					$uniqueFormData[$step - $stepCount['steps'] - 1] = $form->getData();
					$session->set('uniqueFormData', $uniqueFormData);
				} 

				if($step == $test->getStepCount()['steps']) {
					$session->set('evaluation', $test->evaluate($formData));
				}
				else if($step == $test->getStepCount()['total']) {
					return $this->redirect($this->generateUrl('tum_ventureinitiative_test_wizard_single_result', array('testId' => $testId)));
				}
				
				return $this->redirect($this->generateUrl('tum_ventureinitiative_test_wizard_single', array('testId' => $testId, 'step' => $step + 1)));
			}

			return $this->render("TUMVentureinitiativeTestBundle:Wizard:questionnaire.html.twig",
					array('stepView' => $currentStep->getView(),
							'form' => $form->createView(),
							'currentStep' => $step,
							'stepCount' => $test->getStepCount(),
							'testRecord' => $testRecord));
			
		}
		else {
			throw $this->createNotFoundException('There is no step '.$step.' for test '.$testName);
		}
		
	}
	
	public function resultSingleAction($testId, $authToken = null, Request $request) {
	
		$em = $this->getDoctrine()->getManager();
		$testRepository = $em->getRepository('TUMVentureinitiativeTestBundle:Test');
		$testRecord = $testRepository->findOneById($testId);

		$testType = $testRecord->getType();
		$test = new $testType;
	
		$data = array('evaluation' => array('self' => $request->getSession()->get('evaluation')), 'uniqueSteps' => $request->getSession()->get('uniqueFormData'));
		$result = $test->calculateResult($data);

		$request->getSession()->set('result', $result);
		
		return $this->render('TUMVentureinitiativeTestBundle:Wizard:result.html.twig', array('result' => $result, 'test' => $test));
				
	}
	
	public function pdfAction(Request $request) {
		
		$testName = 'big5';
		
		$testClass = $this->testNamespace.'\\'.$testName.'\\'.$testName;
		$test = new $testClass;
		
		$pdf = $this->get('knp_snappy.pdf')->getOutputFromHtml(
				$this->renderView($test->getResultView(), array('test' => $test, 'result' => $request->getSession()->get('result')))
			);
		
		return new Response($pdf, 200, array('Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="result.pdf"'));
		
	}
	
	public function groupAction($testId, $step, $authToken, Request $request) {
	
		$em = $this->getDoctrine()->getManager();
		$testRepository = $em->getRepository('TUMVentureinitiativeTestBundle:Test');
		$testRecord = $testRepository->findOneById($testId);

		$testType = $testRecord->getType();
		$test = new $testType;
		$steps = $test->getSteps();
		$stepCount = $test->getStepCount();
		$session = $request->getSession();
		
		$em = $this->getDoctrine()->getManager();
		$participantRepository = $em->getRepository('TUMVentureinitiativeGroupBundle:Participant');
		$groupEvaluationRepository = $em->getRepository('TUMVentureinitiativeGroupBundle:GroupEvaluation');
		
		if($participant = $participantRepository->findOneBy(array('auth_token' => $authToken))){
			$groupEvaluations = $groupEvaluationRepository->findBy(array('evaluating_participant' => $participant->getId()), array('id' => 'ASC'));
			$rounds = count($groupEvaluations);
		}
		else {
			throw $this->createNotFoundException('Authentication token does not exist!');
		}
		
		$stepCount['total'] = $stepCount['steps'] * $rounds + $stepCount['uniqueSteps'];
		
		if($step >= 1 && $step <= $stepCount['total']) {
			
			if($step <= $stepCount['steps'] * $rounds) {
				
				$currentParticipantIndex = ceil($step/$stepCount['steps']) - 1;
				$currentStepIndex = ($step - 1) % $stepCount['steps'];

				$assignedParticipant = $groupEvaluations[$currentParticipantIndex]->getEvaluatedParticipant();
				$currentStep = $steps[$currentStepIndex];
			}
			else {
				$assignedParticipant = $participant;
				$currentUniqueStepIndex = $step - $stepCount['steps'] * $rounds - 1;
				$currentStepIndex = $stepCount['steps'] + $currentUniqueStepIndex;
				$currentStep = $steps[$currentStepIndex];
			}
			
			$form = $this->createForm($currentStep->getFormType());
			
			if($step <= $stepCount['steps'] * $rounds) {
				
				if(isset($groupEvaluations[$currentParticipantIndex]->getFormData()[$currentStepIndex])) {
					$form->setData($groupEvaluations[$currentParticipantIndex]->getFormData()[$currentStepIndex]);
				}
				
			}
			else {
				
				$groupEvaluation = $groupEvaluationRepository->findOneBy(array('evaluating_participant' => $participant->getId(), 'evaluated_participant' => $participant->getId()));
				
				if(isset($groupEvaluation->getFormData()['unique'][$currentUniqueStepIndex])) {
					$form->setData($groupEvaluation->getFormData()['unique'][$currentUniqueStepIndex]);
				}
				
			}
			
			$form->handleRequest($request);
			
			if($form->isValid()) {
				
				if($step <= $stepCount['steps'] * $rounds && $step % $stepCount['steps'] == 0) {
					
					$persistedFormData = $groupEvaluations[$currentParticipantIndex]->getFormData();
					$persistedFormData[$currentStepIndex] = $form->getData(); 
					$groupEvaluations[$currentParticipantIndex]->setFormData($persistedFormData);
					
					$evaluation = $test->evaluate($groupEvaluations[$currentParticipantIndex]->getFormData());
					$groupEvaluations[$currentParticipantIndex]->setEvaluation($evaluation);
					$em->flush();
				}
				else if($step <= $stepCount['steps'] * $rounds) {
					$persistedFormData = $groupEvaluations[$currentParticipantIndex]->getFormData();
					$persistedFormData[$currentStepIndex] = $form->getData(); 
					$groupEvaluations[$currentParticipantIndex]->setFormData($persistedFormData);
					$em->flush();
				}
				else if($step > $stepCount['steps'] * $rounds) {
					$persistedFormData = $groupEvaluation->getFormData();
					$persistedFormData['unique'][$currentUniqueStepIndex] = $form->getData();
					$groupEvaluation->setFormData($persistedFormData);
					$em->flush();

					
					if($step == $stepCount['total']) {
						return $this->redirect($this->generateUrl('tum_ventureinitiative_test_wizard_group_result_auth', array('testId' => $testId, 'authToken' => $authToken)));
					}
				}
				
				return $this->redirect($this->generateUrl('tum_ventureinitiative_test_wizard_group_auth', array('testId' => $testId, 'step' => $step + 1, 'authToken' => $authToken)));
				
			}
			
			return $this->render("TUMVentureinitiativeTestBundle:Wizard:questionnaire.html.twig", 
					array('step' => $currentStep, 
						  'form' => $form->createView(),
						  'rounds' => $rounds,
						  'currentStep' => $step,
						  'assignedParticipant' => $assignedParticipant,
						  'testRecord' => $testRecord,
			   			  'stepCount' => $stepCount,
						  'stepView' => $currentStep->getView()));
			
		}
		else {
			throw $this->createNotFoundException('There is no step '.$step.' for test '.$testName);
		}
				
	}

	public function resultGroupAction($testId, $authToken, Request $request) {
		
		$em = $this->getDoctrine()->getManager();
		$testRepository = $em->getRepository('TUMVentureinitiativeTestBundle:Test');
		$testRecord = $testRepository->findOneById($testId);

		$testType = $testRecord->getType();
		$test = new $testType;
			
		$em = $this->getDoctrine()->getManager();
		$participantRepository = $em->getRepository('TUMVentureinitiativeGroupBundle:Participant');
		$groupEvaluationRepository = $em->getRepository('TUMVentureinitiativeGroupBundle:GroupEvaluation');
			
		if($participant = $participantRepository->findOneBy(array('auth_token' => $authToken))){
			$groupEvaluations = $groupEvaluationRepository->findBy(array('evaluating_participant' => $participant->getId()), array('id' => 'ASC'));
		}
		else {
			throw $this->createNotFoundException('Authentication token does not exist!');
		}
	
		$data = array();
		
		foreach($groupEvaluations as $groupEvaluation) {				
			if($groupEvaluation->getEvaluatedParticipant()->getId() == $participant->getId()) {
				$data['evaluation']['self'] = $groupEvaluation->getEvaluation();
				$data['uniqueSteps'] = $groupEvaluation->getFormData()['unique'];
			}
			else {
				$data['evaluation']['group'][] = $groupEvaluation->getEvaluation();
			}	
		}
		
		$result = $test->calculateResult($data);
	
		return $this->render('TUMVentureinitiativeTestBundle:Wizard:result.html.twig', array('result' => $result, 'test' => $test));
		
	}

	
	
	public function wizardAction($testName, $step, $authToken = null, Request $request) {
		
		$testClass = $this->testNamespace.'\\'.$testName.'\\'.$testName;
		
		if(class_exists($testClass) && in_array($this->testInterface, class_implements($testClass))) {
			
				$test = new $testClass;
				$rounds = 1;
				$session = $request->getSession();
				$assignedParticipant = null;
				$isGroupEvaluation = false;
				
				$em = $this->getDoctrine()->getManager();
				$participantRepository = $em->getRepository('TUMVentureinitiativeGroupBundle:Participant');
				$groupEvaluationRepository = $em->getRepository('TUMVentureinitiativeGroupBundle:GroupEvaluation');
				
				if($step <= $rounds) {
					$currentStep = $test->getSteps()[$step - 1];
				}
				else {
					$currentStep = $test->getUniqueStep();
				}
				
				if($authToken != null) {
				
					$isGroupEvaluation = true;
					
					$participant = $participantRepository->findOneBy(array('auth_token' => $authToken));
					$groupEvaluations = $groupEvaluationRepository->findBy(array('evaluating_participant' => $participant->getId()), array('id' => 'ASC'));
					$rounds = count($groupEvaluations);
					
					if($step <= $rounds) {					
						$assignedParticipant = $groupEvaluations[$step-1]->getEvaluatedParticipant();
					}
					else {
						$assignedParticipant = $participant;
					}
					
				}
				
				$form = $this->createForm($currentStep->getFormType());
				
				$form->handleRequest($request);
				
				if($form->isValid())
				{
					if($isGroupEvaluation) {
						
						if($step <= $rounds) {
							$groupEvaluations[$step-1]->setEvaluation($test->evaluateStep($form->getData()));
							$em->flush();
							return $this->redirect($this->generateUrl('tum_ventureinitiative_test_wizard_auth', array('testName' => $testName, 'step' => $step + 1, 'authToken' => $authToken)));
						}
						else {
							// Thank You Page or Result Page
						}
					}
					else {
						
						if($step <= $rounds) {
							$session->set('evaluatedStepData', $test->evaluateStep($form->getData())); 
							return $this->redirect($this->generateUrl('tum_ventureinitiative_test_wizard', array('testName' => $testName, 'step' => $step + 1)));
						}
						else {
 							$session->set('uniqueStep', $form->getData());
 							return $this->redirect($this->generateUrl('tum_ventureinitiative_test_wizard_result', array('testName' => $testName)));
						}
					}
				}
				
				return $this->render("TUMVentureinitiativeTestBundle:Wizard:questionnaire.html.twig", 
						array('step' => $currentStep, 
							  'form' => $form->createView(),
							  'rounds' => $rounds,
							  'currentStep' => $step,
							  'assignedParticipant' => $assignedParticipant,
							  'test' => $test,
				   			  'stepCount' => $test->getStepCount(),
							  'stepView' => $currentStep->getView()));
			
		}
		else {
			
			return $this->render('TUMVentureinitiativeTestBundle:Default:index.html.twig', array('name' => 'ERROR!!'));
			
		}

	}
	
	public function resultAction($testName, Request $request) {
		
		$testClass = $this->testNamespace.'\\'.$testName.'\\'.$testName;
		$session = $request->getSession();
		$data = array('step' => $session->get('evaluatedStepData'), 'uniqueStep' => $session->get('uniqueStep'));
		$test = new $testClass;
		$result = $test->calculateResult($data);
		return $this->render('TUMVentureinitiativeTestBundle:Wizard:result.html.twig', array('result' => $result, 'test' => $test));
		
	}

	
}
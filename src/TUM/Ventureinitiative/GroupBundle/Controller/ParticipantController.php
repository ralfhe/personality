<?php

namespace TUM\Ventureinitiative\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TUM\Ventureinitiative\GroupBundle\Form\Type\ParticipantType;
use TUM\Ventureinitiative\GroupBundle\Entity\Participant;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Util\TokenGenerator;
use Doctrine\Common\Util\Debug;

class ParticipantController extends Controller {
	
    public function addAction(Request $request, $groupId) {
    	
    	$participant = new Participant();
    	
    	$participantForm = $this->createForm(new ParticipantType(), $participant);
    	
    	$participantCSVForm = $this->createFormBuilder()
	    	->add('file', 'file', array('label' => 'CSV File'))
	    	->add('delimiter', 'choice', array('choices' => array(',' => ',', ';' => ';')))
	    	->getForm();
    	 
    	$participantPersistForm = $this->createFormBuilder()
    		->add('storeParticipants', 'submit')
    		->add('abort', 'submit')
    		->getForm();
    	
    	$participantForm->handleRequest($request);
    	$participantCSVForm->handleRequest($request);
    	$participantPersistForm->handleRequest($request);
    	 
    	$session = $request->getSession();
    	$tokenGenerator = new TokenGenerator();
    	 
    	$options = array(
    			'headline' => 'Add Participants',
    			'participantFormSubmitButtonText' => 'Add Participants',
    			'participantForm' => $participantForm->createView(),
    			'participantCSVFormSubmitButtonText' => 'Upload Participants',
    			'participantCSVForm' => $participantCSVForm->createView(),
    			'participantPersistForm' => $participantPersistForm->createView(),
    			'participantPersistFormSubmitButtonText' => 'Store Participants');
    	 
    	if($participantPersistForm->isValid()) {
    		 
    		if($participantPersistForm->get('storeParticipants')->isClicked()) {
	    		
	    		$participantsToAdd = $session->get('participantsToAdd');
	    		 
	    		$em = $this->getDoctrine()->getManager();
	    		
	    		$group = $em->find('TUM\Ventureinitiative\GroupBundle\Entity\Group', $groupId);
	    		 
	    		foreach ($participantsToAdd as $participant) {
	    			$participant->setGroup($group);
	    			$participant->setAuthToken($tokenGenerator->generateToken());
	    			$em->persist($participant);
	    		}
	    		 
	    		$em->flush();
	    		 
	    		$session->remove('participantsToAdd');
    		}
    		
    		return $this->redirect($this->generateUrl('tum_ventureinitiative_group_settings', array('groupId' => $groupId)));
    		
    	}
    	else if($participantForm->isValid()) {
    		 
    		if(!$session->has('participantsToAdd')) {
    			$session->set('participantsToAdd', array());
    		}
    	
    		$participantsToAdd = $session->get('participantsToAdd');
    		$participantsToAdd[] = $participantForm->getData();
    		$session->set('participantsToAdd', $participantsToAdd);
    	
    		return $this->render('TUMVentureinitiativeGroupBundle:Participant:add.html.twig', $options);
    		 
    	}else if($participantCSVForm->isValid()) {
    	
    		if(!$session->has('participantsToAdd')) {
    			$session->set('participantsToAdd', array());
    		}
    	
    		$participantsToAdd = $session->get('participantsToAdd');
    	
    		$csv = $participantCSVForm->get('file')->getData();
    		$delimiter = $participantCSVForm->get('delimiter')->getData();
    		$participants = str_getcsv($csv, $delimiter);
    		$tmp_file = $_FILES['form']['tmp_name']['file'];
    		 
    		if(!file_exists($tmp_file) || !is_readable($tmp_file)) {
    			var_dump('File not readable');
    		}
    		 
    		$header = NULL;
    		$csvData = array();
    	
    		if (($handle = fopen($tmp_file, 'r')) !== FALSE) {
    			
    			while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
    				
    				if(!$header) {
    					$header = $row;
    				}
    				else {
    					$csvData[] = array_combine($header, $row);	
    				}
    			}
    			fclose($handle);
    		}
    	
    		foreach ($csvData as $csvData) {
    	
    			$participant =  new Participant();
    	
    			$participant->setFirstname($csvData['firstname']);
    			$participant->setLastname($csvData['lastname']);
    			$participant->setEmail($csvData['e-mail']);
    	
    			$participantsToAdd[] = $participant;
    			$session->set('participantsToAdd', $participantsToAdd);

    		}
    		 
    		return $this->render('TUMVentureinitiativeGroupBundle:Participant:add.html.twig', $options);
    		 
    	} 
    		
    	return $this->render('TUMVentureinitiativeGroupBundle:Participant:add.html.twig', $options);
    	
    }
    
    public function editAction()
    {
    	$name = "Group";
    	return $this->render('TUMVentureinitiativeGroupBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function deleteAction($participantId) {
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$participantRepository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Participant');
    	$groupRepository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Group');
    	$groupEvaluationRepository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:GroupEvaluation');
    	$testRepository = $this->getDoctrine()->getRepository('TUMVentureinitiativeTestBundle:Test');
    	
    	$participant = $participantRepository->find($participantId);
    	$groupId = $participant->getGroup()->getId();
    	$em->remove($participant);
    	$em->flush();

    	return $this->redirect($this->generateUrl('tum_ventureinitiative_group_settings', array('groupId' => $groupId)));
    	
    }
    
    public function infoAction() {

	}
	
	public function mailAction($participantId) {
		 
		$participantRepository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Participant');
		$participant = $participantRepository->find($participantId);
		 
		$content = 'Wellcome, you have been enrolled to an group evaluation. To start it, please click on the following link: ' . 
    				$this->generateUrl('tum_ventureinitiative_test_overview', array('test' => 'big5', 'auth_token' => $participant->getAuthToken()), true);
    		
    		$message = \Swift_Message::newInstance()
	    		->setSubject('Ventureinitiative - Group Evaluation')
	    		->setFrom('idp@ralfhecktor.de')
	    		->setTo($participant->getEmail())
	    		->setBody($this->renderView('TUMVentureinitiativeGroupBundle:Participant:email.html.twig', array('content' => $content)), 'text/html');
    		 
    		$this->get('mailer')->send($message);
	
	
		return $this->redirect($this->generateUrl('tum_ventureinitiative_group_index'));
		 
	}

    
}

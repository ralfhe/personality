<?php

namespace TUM\Ventureinitiative\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MailController extends Controller
{	
    public function startAction($participantId)
    {
        $participantRepository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Participant');
		$participant = $participantRepository->find($participantId);

		$testName = $participant->getGroup()->getTest()->getName();
		$url = $this->generateUrl('tum_ventureinitiative_test_wizard_group_auth', array('testName' => 'big5', 'authToken' => $participant->getAuthToken()), true);
    		
    	$message = \Swift_Message::newInstance()
	    	->setSubject('Ventureinitiative - Group Evaluation')
	    	->setFrom('idp@ralfhecktor.de')
	   		->setTo($participant->getEmail());
    	
    	$img['wiwi'] = $message->embed(\Swift_Image::fromPath('img/wiwi_logo_blue_small.png'));
    	$img['tum'] = $message->embed(\Swift_Image::fromPath('img/tum_logo_blue_small.png'));
    	
	   	$message->setBody($this->renderView('TUMVentureinitiativeGroupBundle:Mail:start.html.twig', 
	   			array('participant' => $participant, 
	   				  'testName' => $testName, 
	   				  'url' => $url,
	   				  'img' => $img)), 'text/html');
    		 
    	$this->get('mailer')->send($message);
	
		return $this->redirect($this->generateUrl('tum_ventureinitiative_group_settings', array('groupId' => $participant->getGroup()->getId())));
    }
    
    public function reminderAction($participantId)
    {
    	$participantRepository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Participant');
		$participant = $participantRepository->find($participantId);

		$testName = $participant->getGroup()->getTest()->getName();
		$url = $this->generateUrl('tum_ventureinitiative_test_wizard_group_auth', array('testName' => 'big5', 'authToken' => $participant->getAuthToken()), true);
    		
    	$message = \Swift_Message::newInstance()
	    	->setSubject('Ventureinitiative - Group Evaluation')
	    	->setFrom('idp@ralfhecktor.de')
	   		->setTo($participant->getEmail());
    	
    	$img['wiwi'] = $message->embed(\Swift_Image::fromPath('img/wiwi_logo_blue_small.png'));
    	$img['tum'] = $message->embed(\Swift_Image::fromPath('img/tum_logo_blue_small.png'));
    	
	   	$message->setBody($this->renderView('TUMVentureinitiativeGroupBundle:Mail:reminder.html.twig', 
	   			array('participant' => $participant, 
	   				  'testName' => $testName, 
	   				  'url' => $url,
	   				  'img' => $img)), 'text/html');
    		 
    	$this->get('mailer')->send($message);
	
		return $this->redirect($this->generateUrl('tum_ventureinitiative_group_settings', array('groupId' => $participant->getGroup()->getId())));
    }
    
    public function resultAction()
    {
    	return $this->redirect($this->generateUrl('tum_ventureinitiative_group_index'));
    }
    
    public function stopedAction()
    {
    	return $this->redirect($this->generateUrl('tum_ventureinitiative_group_index'));
    }

}


?>
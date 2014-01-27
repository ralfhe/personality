<?php

namespace TUM\Ventureinitiative\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TUM\Ventureinitiative\GroupBundle\Entity\Group;
use TUM\Ventureinitiative\GroupBundle\Entity\Participant;
use TUM\Ventureinitiative\GroupBundle\Form\Type\GroupType;
use Symfony\Component\HttpFoundation\Request;
use TUM\Ventureinitiative\GroupBundle\Entity\GroupEvaluation;
use FOS\UserBundle\Util\TokenGenerator;
use Doctrine\Common\Util\Debug;


class GroupController extends Controller
{
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$qb = $em->createQueryBuilder();
    	$qb->select('COUNT(test.id)')
    	   ->from('TUMVentureinitiativeTestBundle:Test', 'test')
    	   ->where($qb->expr()->eq('test.status', '?1'))
    	   ->setParameter(1, 1);
    	
    	if($qb->getQuery()->getSingleScalarResult() == 0) {
    		
    		return $this->render('TUMVentureinitiativeGroupBundle:Group:noTest.html.twig');
    		
    	}
    	else {
    	
	    	$repository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Group');
	    	$groups = $repository->findAll();
	    	
	    	if($request->getSession()->has('participantsToAdd')) {
	    		$request->getSession()->remove('participantsToAdd');
	    	}
	    	
	        return $this->render('TUMVentureinitiativeGroupBundle:Group:index.html.twig', array('groups' => $groups));
	        
    	}
    }
    
    public function newAction(Request $request)
    {
    	$group = new Group();
    	$groupForm = $this->createForm(new GroupType(), $group);
    	$groupForm->handleRequest($request);

    	if($groupForm->isValid()) {
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($group);
    		$em->flush();
    		
    		if($groupForm->get('createAndFinish')->isClicked()) {
    			
    			return $this->redirect($this->generateUrl('tum_ventureinitiative_group_index'));
    			    			
    		}
    		else if($groupForm->get('createAndAddUsers')->isClicked()) {
    			
    			return $this->redirect($this->generateUrl('tum_ventureinitiative_participant_add', array('groupId' => $group->getId())));
    			
    		}
    	}
    	
    	$options = array('headline' => 'New Group',
    					 'groupForm' => $groupForm->createView(),
    					 'groupFormSubmitButtonText' => 'Create');
    	
    	return $this->render('TUMVentureinitiativeGroupBundle:Group:groupForm.html.twig', $options);
    	
    }
    
    public function editAction(Request $request, $groupId)
    {
    	$repository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Group');
    	$group = $repository->find($groupId);
    	
    	$groupForm = $this->createForm(new GroupType(), $group);
    	$groupForm->handleRequest($request);

    	if($groupForm->isValid()) {
    	
    		$em = $this->getDoctrine()->getManager();
    		$em->flush();
    	
    		if($groupForm->get('createAndFinish')->isClicked()) {
    			 
    			return $this->redirect($this->generateUrl('tum_ventureinitiative_group_settings', array('groupId' => $group->getId())));
    	
    		}
    		else if($groupForm->get('createAndAddUsers')->isClicked()) {
    			 
    			return $this->redirect($this->generateUrl('tum_ventureinitiative_participant_add', array('groupId' => $group->getId())));
    			 
    		}
    	}
    	
    	$options = array('headline' => 'Edit Group',
    			'groupForm' => $groupForm->createView(),
    			'groupFormSubmitButtonText' => 'Edit');
    	
    	return $this->render('TUMVentureinitiativeGroupBundle:Group:groupForm.html.twig', $options);
    }
    
    public function deleteAction($groupId)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$group = $em->getPartialReference('TUM\Ventureinitiative\GroupBundle\Entity\Group', array('id' => $groupId));
    	$em->remove($group);
    	$em->flush();
    	 
    	return $this->redirect($this->generateUrl('tum_ventureinitiative_group_index'));
    }
    
    public function startAction($groupId)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$participantRepository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Participant');
    	$participants = $participantRepository->findBy(array('group' => $groupId));
    	$shuffledParticipants = $participants;
    	shuffle($shuffledParticipants);
    	$groupRepository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Group');
    	$group = $groupRepository->find($groupId);
    	$rounds = $group->getAssignmentAmount();
    	$test = $em->getPartialReference('TUM\Ventureinitiative\TestBundle\Entity\Test', array('id' => $group->getTest()->getId()));
	
    	for($i = 0; $i < count($shuffledParticipants); $i++) {
    		
    		$groupEvaluation = new GroupEvaluation();
    		 
    		$groupEvaluation->setEvaluatingParticipant($shuffledParticipants[$i]);
    		$groupEvaluation->setEvaluatedParticipant($shuffledParticipants[$i]);
    		$groupEvaluation->setResult("");
    		
    		$em->persist($groupEvaluation);
    		$em->flush();
    		
    		for($j = 1; $j <= $rounds; $j++) {
    			
    			$groupEvaluation = new GroupEvaluation();
    			
    			$groupEvaluation->setEvaluatingParticipant($shuffledParticipants[$i]);
    			$groupEvaluation->setEvaluatedParticipant($shuffledParticipants[($i+$j) % count($shuffledParticipants)]);
    			$groupEvaluation->setResult("");

    			$em->persist($groupEvaluation);
    			$em->flush();
    		}
    		
    		$this->get('tum_ventureinitiative_group.mailer')->startAction($shuffledParticipants[$i]->getId());
    		
    	}
    	
    	$group->setStatus(1);
    	
    	$em->flush();
    	
    	return $this->redirect($this->generateUrl('tum_ventureinitiative_group_settings', array('groupId' => $groupId)));
    }
    
    public function stopAction($groupId)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$groupRepository = $em->getRepository('TUMVentureinitiativeGroupBundle:Group');
    	$group = $groupRepository->find($groupId);
    	$group->setStatus(3);
    	$em->flush();
    	
    	$name = "Group";
    	return $this->render('TUMVentureinitiativeGroupBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function settingsAction($groupId) {
    	
    	$repository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Group');
    	$group = $repository->find($groupId);
    	$participants = $group->getParticipants();

    	$evaluationCount = array();
    	
    	foreach($participants as $participant) {
    		
    		$groupEvaluations = $participant->getEvaluating();
    		
    		$evaluationCount[$participant->getId()]['total'] = count($groupEvaluations);
    		$evaluationCount[$participant->getId()]['done'] = 0;
    		
    		foreach($groupEvaluations as $groupEvaluation) {
    			if($groupEvaluation->getEvaluation() != null) {
    				$evaluationCount[$participant->getId()]['done']++;
    			}
    		}
    		
    	}
    	
    	$options = array('group' => $group, 'participants' => $participants, 'evaluationCount' => $evaluationCount);
    	
    	return $this->render('TUMVentureinitiativeGroupBundle:Group:groupInfo.html.twig', $options);
    	
    }
   
}

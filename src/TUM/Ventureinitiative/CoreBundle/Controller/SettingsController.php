<?php

namespace TUM\Ventureinitiative\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TUM\Ventureinitiative\CoreBundle\Form\Type\RegistrationFormType;

class SettingsController extends Controller
{
    public function indexAction()
    {
    	$userManager = $this->container->get('fos_user.user_manager');
    	
    	$users = $userManager->findUsers();
    	
        return $this->render('CoreBundle:Settings:index.html.twig', array('users' => $users));
    }
    
    public function addUserAction()
    {
    	
    	$userForm = $this->createForm(new RegistrationFormType(), $user);
    	 
    	$userForm->handleRequest($request);
    	 
    	if($userForm->isValid()) {
    	
    	
    	}
    		
    	return $this->render('CoreBundle:Settings:index.html.twig', array('name' => 'Core'));
    }
    
    public function editUserAction()
    {
    	return $this->render('CoreBundle:Settings:index.html.twig', array('name' => 'Core'));
    }
    
    public function deleteUserAction()
    {
    	return $this->render('CoreBundle:Settings:index.html.twig', array('name' => 'Core'));
    }
    
    public function deactivateUserAction()
    {
    	return $this->render('CoreBundle:Settings:index.html.twig', array('name' => 'Core'));
    }
    
    public function activateUserAction()
    {
    	return $this->render('CoreBundle:Settings:index.html.twig', array('name' => 'Core'));
    }
 
}


?>
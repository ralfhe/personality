<?php

namespace TUM\Ventureinitiative\GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$name = "Group";
        return $this->render('TUMVentureinitiativeGroupBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function newAction()
    {
    	$name = "Group";
    	return $this->render('TUMVentureinitiativeGroupBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function editAction()
    {
    	$name = "Group";
    	return $this->render('TUMVentureinitiativeGroupBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function deleteAction()
    {
    	$name = "Group";
    	return $this->render('TUMVentureinitiativeGroupBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function startAction()
    {
    	$name = "Group";
    	return $this->render('TUMVentureinitiativeGroupBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function stopAction()
    {
    	$name = "Group";
    	return $this->render('TUMVentureinitiativeGroupBundle:Default:index.html.twig', array('name' => $name));
    }
}

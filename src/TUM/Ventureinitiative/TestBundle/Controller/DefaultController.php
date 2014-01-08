<?php

namespace TUM\Ventureinitiative\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Util\Debug;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TUMVentureinitiativeTestBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function testAction($test, $auth_token) {
    	
    	$repository = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Participant');
    	$participant = $repository->find(10);

    	$repository2 = $this->getDoctrine()->getRepository('TUMVentureinitiativeGroupBundle:Group');
    	$group = $repository2->find(1);
    	
    	var_dump($group->getTest()->getId());
    
    	var_dump($participant);
    	
    	$name = $participant->getFirstname() ;
    	
    	return $this->render('TUMVentureinitiativeTestBundle:Default:index.html.twig', array('name' => $name));
    	
    }
}

<?php

namespace TUM\Ventureinitiative\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreBundle:Frontend:index.html.twig', array('name' => 'Core'));
    }
    
}


?>
<?php

namespace TUM\Ventureinitiative\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackendController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreBundle:Backend:index.html.twig', array('name' => 'Core'));
    }
    

}


?>
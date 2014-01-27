<?php

namespace TUM\Ventureinitiative\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackendController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('tum_ventureinitiative_group_index'));
    }
    

}


?>
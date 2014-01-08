<?php

namespace TUM\Ventureinitiative\StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TUM\Ventureinitiative\UserManagementBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Util\Debug;
use TUM\Ventureinitiative\StudentBundle\Entity\Student;
use TUM\Ventureinitiative\UserManagementBundle\Form\Type\StudentType;

class DefaultController extends Controller
{
	public function overviewAction($page = 1)
    {
    	$this->getRequest()->getSession()->remove('studentsToAdd');
    	
    	$pageData = $this->get('tum_ventureinitiative_student.service')->listStudents($page, 10);

    	$searchForm = $this->createFormBuilder()
    		->setAction($this->generateUrl('tum_ventureinitiative_student_search'))
	    	->add('query', 'text')
	    	->add('searchSubmit', 'submit')
	    	->getForm();
    	
    	$options = array('students' => $pageData['students'], 
    			'searchForm' => $searchForm->createView(), 
    			'page' => $page,
    			'pageCount' => $pageData['pageCount']);
    	
        return $this->render('TUMVentureinitiativeStudentBundle:Default:index.html.twig', $options);
    }
        
    public function deleteAction($id) {
    
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$student = $em->getPartialReference('TUM\Ventureinitiative\StudentBundle\Entity\Student', array('id' => $id));
    	
    	$em->remove($student);
    	$em->flush();
    	
    	return $this->redirect($this->generateUrl('tum_ventureinitiative_student_overview'));
    	
    }
    
    public function editAction($id) {
    	
    	$repository = $this->getDoctrine()->getRepository('TUMVentureinitiativeStudentBundle:Student');
    	 
   		$student = $repository->find($id);
    	  		
    	$studentForm = $this->createForm(new StudentType(), $student);
    	 
    	$studentForm->handleRequest($request);
    	 
    	if($studentForm->isValid()) {
    	
    		$student = $studentForm->getData();
    	
    		//$em = $this->getDoctrine()->getEntityManager();
    		//$em->flush();
    	
    		return $this->redirect($this->generateUrl('tum_ventureinitiative_student_index'));
    	
    	}
    	
    	return $this->render('TUMVentureinitiativeStudentBundle:Default:edit.html.twig', array('headline' => 'Edit Student',
    			'submitButtonText' => 'Save Changes',
    			'studentForm' => $studentForm->createView()));
    	
    }
       
    public function addAction(Request $request) {
    	
    	$user = new Student();
    	 
    	$userForm = $this->createForm(new UserType(), $user);

    	$userCSVForm = $this->createFormBuilder()
	    	->add('file', 'file', array('label' => 'CSV File'))
	    	->add('separator', 'choice', array('choices' => array(',' => ',', ';' => ';')))
	    	->getForm();
    	
    	$userPersistForm = $this->createFormBuilder()->getForm();
    	  	
    	$userForm->handleRequest($request);
    	$userCSVForm->handleRequest($request);
    	$userPersistForm->handleRequest($request);
    	
    	$session = $request->getSession();
    	
    	$options = array(
    			'headline' => 'Add Users',
    			'userFormSubmitButtonText' => 'Add User',
    			'userForm' => $userForm->createView(),
    			'userCSVFormSubmitButtonText' => 'Upload Users',
    			'userCSVForm' => $userCSVForm->createView(),
    			'userPersistForm' => $userPersistForm->createView(),
    			'userPersistFormSubmitButtonText' => 'Store Users');
    	
    	if($userPersistForm->isValid()) {
    	
    		$usersToAdd = $session->get('usersToAdd');
    	
    		$em = $this->getDoctrine()->getManager();
    	
    		foreach ($usersToAdd as $user) {
    			$em->persist($user);
    		}
    	
    		$em->flush();
    	
    		$session->remove('usersToAdd');
    	
    		return $this->redirect($this->generateUrl('tum_ventureinitiative_student_overview'));
    	
    	} 
    	else if($userForm->isValid()) {
    	
    		if(!$session->has('usersToAdd')) {
    			$session->set('usersToAdd', array());
    		}
    		
    		$usersToAdd = $session->get('usersToAdd');
    		
    		$usersToAdd[] = $userForm->getData();

    		$session->set('usersToAdd', $usersToAdd);

    		return $this->render('TUMVentureinitiativeStudentBundle:Default:add.html.twig', $options);
    	
    	}else if($userCSVForm->isValid()) {

    		if(!$session->has('usersToAdd')) {
    			$session->set('usersToAdd', array());
    		}
    		
    		$usersToAdd = $session->get('usersToAdd');
    		
    		$csv = $userCSVForm->get('file')->getData();
    		$delimiter = $userCSVForm->get('separator')->getData();
    	
    		$users = str_getcsv($csv, $delimiter);
    		
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
    			 
    			$user =  new Student();
    			 
    			$user->setFirstname($csvData['firstname']);
    			$user->setLastname($csvData['lastname']);
    			$user->setEmail($csvData['e-mail']);
    			 
    			$usersToAdd[] = $user;
    		
    			$session->set('usersToAdd', $usersToAdd);
    			 
    			 
    		}
    	
    		return $this->render('TUMVentureinitiativeStudentBundle:Default:add.html.twig', $options);
    		 
    	}
 	 
    	return $this->render('TUMVentureinitiativeStudentBundle:Default:add.html.twig', $options);
    	
    }
    
    public function searchAction($page = 1) {
    	
    	$searchForm = $this->createFormBuilder()
    		->setAction($this->generateUrl('tum_ventureinitiative_student_search'))
	    	->add('query', 'text')
	    	->add('searchSubmit', 'submit')
	    	->getForm();
    	
    	$request = $this->getRequest();
    	
    	$searchForm->handleRequest($request);
    	
    	if($searchForm->isValid()) {

    		$query = $searchForm->get('query')->getData();
    		
    		$pageData = $this->get('tum_ventureinitiative_student.service')->searchStudents($query);
    		
    	}
    	
    	$options = array('students' => $pageData['students'][0], 
    			'searchForm' => $searchForm->createView(),
    			'pageCount' => $pageData['pageCount'],
    			'page' => $page);
    	
    	return $this->render('TUMVentureinitiativeStudentBundle:Default:index.html.twig', $options);
    	
    }
}

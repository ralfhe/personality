<?php

namespace TUM\Ventureinitiative\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TUM\Ventureinitiative\UserManagementBundle\Entity\Role;
use TUM\Ventureinitiative\UserManagementBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use TUM\Ventureinitiative\UserManagementBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Util\Debug;

class MainController extends Controller
{
    public function overviewAction($page = 1)
    {
    	$this->getRequest()->getSession()->remove('usersToAdd');

    	$repository = $this->getDoctrine()->getRepository('UserManagementBundle:User');
    	
    	$paging = $repository->paging($page, 10);
    	
    	$searchForm = $this->createFormBuilder()
    		->setAction($this->generateUrl('user_management_search'))
	    	->add('query', 'text')
	    	->add('searchSubmit', 'submit')
	    	->getForm();
    	
    	$pagingConfig = array('page' => $page, 'pageCount' => $paging['pageCount']);
    	
        return $this->render('UserManagementBundle:Main:overview.html.twig', array('users' => $paging['users'], 'searchForm' => $searchForm->createView(), 'pagingConfig' => $pagingConfig));
    }
    
    public function addUserAction(Request $request) {
    	
    	$user = new User();
    	
    	$userForm = $this->createForm(new UserType(), $user); 
    	
    	$userForm->handleRequest($request);
    	
    	if($userForm->isValid()) {
    		
    		$user = $userForm->getData();
    		
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->persist($user);
    		$em->flush();
    		
    		return $this->redirect($this->generateUrl('user_management_homepage'));
    		
    	}

    	return $this->render('UserManagementBundle:Main:add.html.twig', array('headline' => 'Add User',
    		'submitButtonText' => 'Add User',
    		'userForm' => $userForm->createView()));
    
    }
    
    public function deleteUserAction($id) {
    
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$user = $em->getPartialReference('TUM\Ventureinitiative\UserManagementBundle\Entity\User', array('id' => $id));
    	
    	$em->remove($user);
    	$em->flush();
    	
    	return $this->redirect($this->generateUrl('user_management_homepage'));
    	
    }
    
    public function editUserAction($id) {
    	
    	$repository = $this->getDoctrine()->getRepository('UserManagementBundle:User');
    	 
    	$user = $repository->find($id);
    	  		
    	$userForm = $this->createForm(new UserType(), $user);
    	 
//     	$userForm->handleRequest($request);
    	 
//     	if($userForm->isValid()) {
    	
//     		$user = $userForm->getData();
    	
//     		$em = $this->getDoctrine()->getEntityManager();
//     		$em->persist($user);
//     		$em->flush();
    	
//     		return $this->redirect($this->generateUrl('user_management_homepage'));
    	
//     	}
    	
    	return $this->render('UserManagementBundle:Main:userForm.html.twig', array('headline' => 'Edit Student',
    			'submitButtonText' => 'Save Changes',
    			'userForm' => $userForm->createView()));
    	
    }
    
    public function importUserAction(Request $request) {
    	
    	$userCSVForm = $this->createFormBuilder()
    		->add('file', 'file', array('label' => 'CSV File'))
    		->add('separator', 'choice', array('choices' => array(',' => ',', ';' => ';')))
    		->getForm();
    	 
    	$userCSVForm->handleRequest($request);
    	 
    	if($userCSVForm->isValid()) {
    	
    		$csv = $userCSVForm->get('file');
    		$delimiter = $userCSVForm->get('separator')->getData();
    		
    		var_dump($delimiter);
    		
    		$csvData = $csv->getData();
    		
    		$users = str_getcsv($csvData, $delimiter);
    		$em = $this->getDoctrine()->getManager();
    		
    		$tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
    
    		
    		$tmp_file = $_FILES['form']['tmp_name']['file'];
    		
    		if(!file_exists($tmp_file) || !is_readable($tmp_file)) { var_dump('File not readable'); }
    			
    		$header = NULL;
    		$data = array();
    		if (($handle = fopen($tmp_file, 'r')) !== FALSE)
    		{
    			while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE)
    			{
    				if(!$header)
    					$header = $row;
    				else
    					$data[] = array_combine($header, $row);
    			}
    			fclose($handle);
    		}
    		
    		var_dump($data);
    		
    		foreach ($data as $data) {
    			
    			$user =  new User();
    			
    			$user->setFirstname($data['firstname']);
    			$user->setLastname($data['lastname']);
    			$user->setEmail($data['e-mail']);
    			
    			$em->persist($user);
    			
    			
    		}
    		
    		$em->flush();
    		
    		return $this->redirect($this->generateUrl('user_management_homepage'));
    	
    	}
    	
    	return $this->render('UserManagementBundle:Main:userCSVUploadForm.html.twig', array('headline' => 'Upload Users',
    			'submitButtonText' => 'Upload',
    			'userCSVUploadForm' => $userCSVForm->createView()));
    	
    }
    
    public function addAction(Request $request) {
    	
    	$user = new User();
    	 
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
    	
    		return $this->redirect($this->generateUrl('user_management_homepage'));
    	
    	} 
    	else if($userForm->isValid()) {
    	
    		if(!$session->has('usersToAdd')) {
    			$session->set('usersToAdd', array());
    		}
    		
    		$usersToAdd = $session->get('usersToAdd');
    		
    		$usersToAdd[] = $userForm->getData();

    		$session->set('usersToAdd', $usersToAdd);

    		return $this->render('UserManagementBundle:Main:add.html.twig', $options);
    	
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
    			 
    			$user =  new User();
    			 
    			$user->setFirstname($csvData['firstname']);
    			$user->setLastname($csvData['lastname']);
    			$user->setEmail($csvData['e-mail']);
    			 
    			$usersToAdd[] = $user;
    		
    			$session->set('usersToAdd', $usersToAdd);
    			 
    			 
    		}
    	
    		return $this->render('UserManagementBundle:Main:add.html.twig', $options);
    		 
    	}
 	 
    	return $this->render('UserManagementBundle:Main:add.html.twig', $options);
    	
    }
    
    public function searchAction() {
    	
    	$searchForm = $this->createFormBuilder()
    		->setAction($this->generateUrl('user_management_search'))
	    	->add('query', 'text')
	    	->add('searchSubmit', 'submit')
	    	->getForm();
    	
    	$request = $this->getRequest();
    	
    	$searchForm->handleRequest($request);
    	
    	if($searchForm->isValid()) {

    		$query = $searchForm->get('query')->getData();
    		
    		$subQueries = explode(' ', $query);
    		
    		$repo = $this->getDoctrine()->getRepository('UserManagementBundle:User');
    		$qb = $repo->createQueryBuilder('s');
    		
    		$result = array();
    		
    		foreach($subQueries as $sqKey => $sqValue) {
    			$qb->where('s.firstname LIKE :sq OR s.lastname LIKE :sq OR s.email LIKE :sq')
    				->setParameter('sq', '%'.$sqValue.'%');
    			
    			$result[] = $qb->getQuery()->getResult();
    		}

    		
    	}
    	
    	return $this->render('UserManagementBundle:Main:overview.html.twig', array('users' => $result[0], 'searchForm' => $searchForm->createView()));
    	
    }
    
}

<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 10-Mar-18
 * Time: 10:34 AM
 */

namespace Admin\Controller;


use Zend\View\Model\ViewModel;

class CategoryController extends MainController
{	
	public function getEntitymanager(){
		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		return $em;
	}

    public function indexAction(){

    	$em = $this->getEntitymanager();
    	$categories = $em->getRepository('\Admin\Entity\Category')->findAll();

        return new ViewModel(array('categories' => $categories));
    }

    public function addAction(){


        return new ViewModel();
    }
}
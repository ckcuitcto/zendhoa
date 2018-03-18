<?php
namespace Flower\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HomeController extends MainController{
	public function indexAction(){
		return new ViewModel;
	}	

}
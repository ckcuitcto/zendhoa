<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 10-Mar-18
 * Time: 10:34 AM
 */

namespace Flower\Controller;


use Zend\View\Model\ViewModel;


class IndexController extends MainController
{
    public function indexAction(){

        return new ViewModel();
    }
}
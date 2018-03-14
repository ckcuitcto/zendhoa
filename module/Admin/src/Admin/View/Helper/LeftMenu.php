<?php

/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 10-Mar-18
 * Time: 12:10 PM
 */

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;

class LeftMenu extends AbstractHelper
{
    protected $sm;
    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    public function callMenu(){
//        $entityManager = $this->sm->getServiceLocator()->get('doctrine.entitymanager.orm_default');

//        $menus = $entityManager->getRepository('\Blog\Entity\Category')->findAll();


        $str = '<div class="panel panel-default">';
        $str .= '    <div class="panel-heading">';
        $str .= '        <h3 class="panel-title"> Chuyên mục</h3>';
        $str .= '    </div>';
        $str .= '    <div class="panel-body">';
        $str .= "<ul class='nav nav-pills nav-stacked'>";

        $str .= "</ul>";
        $str .= '    </div>';
        $str .= '</div>';

        return $str;
    }
}
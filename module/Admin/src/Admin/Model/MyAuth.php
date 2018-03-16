<?php

/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 16-Mar-18
 * Time: 3:03 PM
 */
namespace Admin\Model;
use Zend\Authentication\Storage;

class MyAuth extends Storage\Session
{
    public function setRememberMe($remember = 0, $time = 2592000){
        if($remember == 1){
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe(){
        $this->session->getManager()->forgetMe();
    }
}
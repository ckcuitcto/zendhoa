<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 14-Mar-18
 * Time: 2:13 AM
 */

namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class VerifyForm extends Form
{
    public function __construct($name){
        parent::__construct($name);
        $this->setAttribute('method','post');
        $this->addElements();
//        $this->addInputFiltersLogin();
    }
    public function addElements(){
        $this->add(array(
            'type' => 'email',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'E-mail',
            )
        ));
        $this->add(array(
            'type' => 'password',
            'name' => 'password',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Password',
            )
        ));

        $this->add(
            array(
                'type' => 'checkbox',
                'name' => 'remember',
                'options' => array(
                    'label' => 'Remember me',
                    'use_hidden_element' => true, // nếu ng dùng k lựa chọn thì mặc định là gì,
                    'checked_value' => true,
                    'unchecked_value' => false,
                )
            )
        );

        $this->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Login',
                'class' => 'btn btn-lg btn-success btn-block'
            ),
        ));
    }
    public function addInputFiltersLogin(){
        $input = new InputFilter();
        $this->setInputFilter($input);

        $input->add(
            array(
                'name' => 'email',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                )
            )
        );

        $input->add(
            array(
                'name' => 'password',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                )
            )
        );

    }
}
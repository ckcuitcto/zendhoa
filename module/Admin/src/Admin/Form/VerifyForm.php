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
    public function __construct($name)
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');
        $this->addElements();
//        $this->addInputFiltersLogin();
    }

    public function addElements()
    {
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
                'name' => 'repassword',
                'type' => 'password',
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Re-Password',

                ),
            )
        );

        $this->add(
            array(
                'type' => 'checkbox',
                'name' => 'remember',
                'options' => array(
                    'label' => 'Remember me',
                    'use_hidden_element' => true, // nếu ng dùng k lựa chọn thì mặc định là gì,
                    'checked_value' => 1,
                    'unchecked_value' => 0,
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

    public function addInputFiltersLogin()
    {
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

    public function addInputFiltersForgot()
    {
        $input = new InputFilter();
        $this->setInputFilter($input);
        $input->add(
            array(
                'name' => 'password',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                ),
                'validators' => array(
                    array('name' => 'NotEmpty'),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 6,
                            'max' => 32,
                            'messages' => array(
                                'stringLengthTooShort' => 'Mật khẩu không được ít hơn %min% kí tự',
                                'stringLengthTooLong' => 'Mật khẩu  không được vượt quá %max% kí tự',
                            )
                        )
                    ),
                )
            )

        );

        $input->add(
            array(
                'name' => 'repassword',
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                ),
                'validators' => array(
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'password'
                        )),
                )
            )

        );
    }
}
<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;


class CategoryForm extends Form
{

    public function __construct($name)
    {
        parent::__construct($name);
        $this->setAttribute('method','post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->addElements();
        $this->addInputFiler();
    }

    public function addElements(){
    	$this->add(array(
    		'name' => 'name',
    		'type' => 'text',
    		'attributes' => array(
    			'class' => 'form-control',
    		),
    		'options' => array(
    			'label' =>'Name',
    		)
    	));

    	$this->add(array(
    		'name' => 'description',
    		'type' => 'textarea',
    		'attributes' => array(
    			'class' => 'form-control',
    			'row' =>'5',
                'id' => 'descriptionEditor'
    		),
    		'options' => array(
    			'label' =>'Description',
    		)
    	));

    	$this->add(array(
    		'name' => 'image',
    		'type' => 'file',
    		'attributes' => array(
    			'class' => 'form-control',
                'id' => 'image',
    		),
    		'options' => array(
    			'label' =>'Image',
    		)
    	));

    	$this->add(array(
    		'name' => 'submit',
    		'type' => 'submit',
    		'attributes' => array(
    			'class' => 'btn btn-primary',
    			'value' => 'Submit'
    		),
    	));
    }

    public function addInputFiler(){
        $input = new InputFilter();
        $this->setInputFilter($input);

        $input->add(array(
            'name' => 'name',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
            'validator' => array(
                array(
                    'name' => 'NotEmpty',
                ),
            )
        ));

        $input->add(array(
            'name' => 'description',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
                array('name' => 'StripTags'),
            ),
        ));


        $fileInput = new FileInput('image');
        $fileInput->setRequired(false);
        $fileInput->getValidatorChain()
            ->attachByName('filesize',      array('max' => 2*1024*1024))
            ->attachByName('filemimetype',  array('mimeType' => 'image/png,image/x-png,image/jpg,img/JPG,image/jpeg,application/pdf'));
        // phần này sẽ đc set bên upload method
//            ->attachByName('fileimagesize', array('maxWidth' => 1000, 'maxHeight' => 1000));
//        $fileInput->getFilterChain()->attachByName(
//            'filerenameupload',
//            array(
//                'target'    => './public/data/images/image.png',
//                'randomize' => true,
//            )
//        );
        $input->add($fileInput);

    }
}

 ?>
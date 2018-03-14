<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;


class ProductForm extends Form
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
    		'name' => 'unit_price',
    		'type' => 'number',
    		'attributes' => array(
    			'class' => 'form-control',
    			'min' => 0,
    		),
    		'options' => array(
    			'label' =>'Price',
    		)
    	));

    	$this->add(array(
    		'name' => 'promotion_price',
    		'type' => 'number',
    		'attributes' => array(
    			'min' => 0,
    			'class' => 'form-control',
    		),
    		'options' => array(
    			'label' =>'Promition Price',
    		)
    	));

    	$this->add(array(
    		'name' => 'image',
    		'type' => 'file',
    		'attributes' => array(
    			'class' => 'form-control',
                'id' => 'image-file',
    		),
    		'options' => array(
    			'label' =>'Image',
    		)
    	));

    	$this->add(array(
    		'name' => 'unit',
    		'type' => 'select',
    		'attributes' => array(
    			'class' => 'form-control',
    		),
    		'options' => array(
    			'label' =>'Unit',
    			'value_options' => array(
    				'1' => 'Chậu',
    				'2' => 'Bô',
    			)
    		)
    	));

    	$this->add(array(
    		'name' => 'id_type',
    		'type' => 'select',
    		'attributes' => array(
    			'class' => 'form-control',
    		),
    		'options' => array(
    			'label' =>'Category',
    		)
    	));

    	$this->add(array(
    		'name' => 'new',
    		'type' => 'radio',
    		'attributes' => array(
    			'value' => '1'
    		),
    		'options' => array(
    			'label' =>'Status',
    			'value_options' => array(
    				'2' => 'New',
    				'1' => 'Old',
    			)
    		)
    	));


    	$this->add(array(
    		'name' => 'quantity',
    		'type' => 'number',
    		'attributes' => array(
    			'class' => 'form-control',
    			'min' => 0,
    		),
    		'options' => array(
    			'label' =>'Quantity',
    		)
    	));

    	$this->add(array(
    		'name' => 'view',
    		'type' => 'number',
    		'attributes' => array(
    			'class' => 'form-control',
    			'min' => 0,
    		),
    		'options' => array(
    			'label' =>'View',
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

        $input->add(array(
            'name' => 'unit_price',
            'required' => true,
        ));

        $input->add(array(
            'name' => 'promotion_price',
            'required' => true,
        ));

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


        $fileInput = new FileInput('image');
        $fileInput->setRequired(true);
        $fileInput->getValidatorChain()
            ->attachByName('filesize',      array('max' => 904800))
            ->attachByName('filemimetype',  array('mimeType' => 'image/png,image/x-png,image/jpg,img/JPG,image/jpeg'));
//            ->attachByName('fileimagesize', array('maxWidth' => 1000, 'maxHeight' => 1000));
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'    => './public/data/images/',
                'randomize' => true,
            )
        );
        $input->add($fileInput);

        $input->add(array(
            'name' => 'quantity',
            'required' => true,
            'validator' => array(
                array(
                    'name' => 'NotEmpty',
                ),
            )
        ));

        $input->add(array(
            'name' => 'view',
            'required' => true,
            'validator' => array(
                array(
                    'name' => 'NotEmpty',
                ),
            )
        ));


    }
}

 ?>
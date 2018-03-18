<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 18-Mar-18
 * Time: 12:51 AM
 */

namespace Admin\Form;


use Zend\Form\Form;

class AccessForm extends Form
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->setAttribute('method','post');
        $this->addElements();
//        $this->addInputFilter();

    }

    public function addElements(){
        $this->add(array(
            'type' => 'CheckBox',
            'name' => 'usercontroller',
            'attributes' => array(
                'id' => 'user'
            ),
            'options' => array(
                'checked_value' => 'user',
                'unchecked_value' => 'OFF'
            )
        ));

        $this->add(array(
            'name' => 'user',
            'type' => 'MultiCheckBox',
            'attributes' => array(
                'class' => 'useraction',
            ),
            'options' => array(
                'label' => 'User Controller',
                'options' => array(
                    'index' => 'Index Action',
                    'add' => 'Add Action',
                    'edit' => 'Edit Action',
                    'delete' => 'List Action',
                )
            )
        ));

        $this->add(array(
            'type' => 'CheckBox',
            'name' => 'categorycontroller',
            'attributes' => array(
                'id' => 'category'
            ),
            'options' => array(
                'checked_value' => 'category',
                'unchecked_value' => 'OFF'
            )
        ));

        $this->add(array(
            'name' => 'category',
            'type' => 'MultiCheckBox',
            'attributes' => array(
                'class' => 'categoryaction',
            ),
            'options' => array(
                'label' => 'Category Controller',
                'options' => array(
                    'index' => 'Index Action',
                    'add' => 'Add Action',
                    'edit' => 'Edit Action',
                    'delete' => 'Delete Action',
                )
            )
        ));

        // chat controller
        $this->add(array(
            'type' => 'CheckBox',
            'name' => 'productcontroller',
            'attributes' => array(
                'id' => 'product'
            ),
            'options' => array(
                'checked_value' => 'product',
                'unchecked_value' => 'OFF'
            )
        ));

        $this->add(array(
            'name' => 'product',
            'type' => 'MultiCheckBox',
            'attributes' => array(
                'class' => 'productaction',
            ),
            'options' => array(
                'label' => 'Product Controller',
                'options' => array(
                    'index' => 'Index Action',
                    'add' => 'Add Action',
                    'edit' => 'Edit Action',
                    'delete' => 'Delete Action',
                    'deleteImage' => 'Delete Image Action',
                )
            )
        ));


        //book controller
        $this->add(array(
            'type' => 'CheckBox',
            'name' => 'usercontroller',
            'attributes' => array(
                'id' => 'user'
            ),
            'options' => array(
                'checked_value' => 'user',
                'unchecked_value' => 'OFF'
            )
        ));

        $this->add(array(
            'name' => 'user',
            'type' => 'MultiCheckBox',
            'attributes' => array(
                'class' => 'useraction',
            ),
            'options' => array(
                'label' => 'User Controller',
                'options' => array(
                    'index' => 'Index Action',
                    'add' => 'Add Action',
                    'edit' => 'Edit Action',
                    'list' => 'List Action',
                    'access' => 'Access Action',
                )
            )
        ));


        $this->add(
            array(
                'type' => 'submit',
                'name' => 'submit',
                'attributes' => array(
                    'value' => 'Update',
                    'class' => 'btn btn-primary'
                )
            )
        );
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 17-Mar-18
 * Time: 6:36 PM
 */
return array(
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/admin',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'verify',
                        'action' => 'login  ',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Verify',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'user' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user[/:action[/:id[-:name]][/page/:page]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'name' => '[a-zA-Z0-9_-]+',
                                'id' => '[0-9]+',
                                'page' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'User',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'category' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/category[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Category',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'product' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/product[/:action[/:id[-:name[.html]]][/page/:page]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'name' => '[a-zA-Z0-9_-]+',
                                'id' => '[0-9]+',
                                'page' => '[0-9]+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Admin\Controller',
                                'controller' => 'Product',
                                'action' => 'index',
                                'page' => 1,
                            ),
                        ),
                    ),
                    'verify' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/verify[/:action[/:code]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'code' => '[a-zA-Z0-9]+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Admin\Controller',
                                'controller' => 'Verify',
                                'action' => 'login',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
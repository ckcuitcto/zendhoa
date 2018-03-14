<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Flower\Controller\Index' => 'Flower\Controller\IndexController',
            'Flower\Controller\Home' => 'Flower\Controller\HomeController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'flower' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/flower',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Flower\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'home' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/home[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Home',
                                'action' => 'index',
                            ),
                        ),
                    ),

                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'flower' => __DIR__ . '/../view',
            'template_map' => array(
                // 'layout/flower' => PATH_APP . '/layouts/flower.phtml',
            ),
        ),
    ),
);

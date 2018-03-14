<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 10-Mar-18
 * Time: 10:08 AM
 */
namespace Admin;

use Admin\Entity\User;

return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\User' => 'Admin\Controller\UserController',
            'Admin\Controller\Product' => 'Admin\Controller\ProductController',
            'Admin\Controller\Category' => 'Admin\Controller\CategoryController',
            'Admin\Controller\Verify' => 'Admin\Controller\VerifyController',
        ),
    ),
    // The following section is new and should be added to your file
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
                        'controller' => 'Index',
                        'action' => 'index',
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
                                'controller' => 'Index',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'user' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'User',
                                'action' => 'list',
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
                            'route' => '/verify[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
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
    'view_manager' => array(
        'template_map' => array(
            'layout/application'            => PATH_APP . '/layouts/application.phtml',
            'layout/admin'                   => PATH_APP . '/layouts/admin.phtml',
            'layout/flower' =>              PATH_APP . '/layouts/flower.phtml',
        ),
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    __NAMESPACE__.'\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
        'authentication' => [
            'orm_default' => [
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Admin\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function (\Admin\Entity\User $user, $passwordGiven) {
                    return $user->getPassword() == md5($passwordGiven) AND $user->getLevel()==2;
                },
            ],
        ],
    ],
    'upload_location' => dirname(__DIR__)."/../../public/data/images",
);
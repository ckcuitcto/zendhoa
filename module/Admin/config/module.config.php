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
            'Admin\Controller\User' => 'Admin\Controller\UserController',
            'Admin\Controller\Product' => 'Admin\Controller\ProductController',
            'Admin\Controller\Category' => 'Admin\Controller\CategoryController',
            'Admin\Controller\Verify' => 'Admin\Controller\VerifyController',
        ),
    ),
    // The following section is new and should be added to your file

    'view_manager' => array(
        'template_map' => array(
            'layout/application'            => PATH_APP . '/layouts/application.phtml',
            'layout/admin'                   => PATH_APP . '/layouts/admin.phtml',
            'layout/flower' =>              PATH_APP . '/layouts/flower.phtml',
        ),
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
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
                    return $user->getPassword() == md5($passwordGiven) AND $user->getLevel()>=2;
                },
            ],
        ],
    ],
    'upload_location' => dirname(__DIR__)."/../../public/data/images",
    'recaptcha' => array(
        'public' => '6Lf65EcUAAAAAHfsKWZj72FJFVflgebWAhZVkJNk',
        'private' => '6Lf65EcUAAAAAExw1XDcvmeeTrXrRTCIgIQdof2U',
    ),
    'email_config' => [
        'forgot' =>[
            'nameFrom' => 'Đức Test Zend Mail',
            'emailFrom' => 'hoasaigonn@gmail.com'
        ]
    ],
    'smtp_config' => array(
        'username' => "hoasaigonn@gmail.com",
        'password' => "giahanthaiduc",
        'ssl' => 'ssl'
    ),
);
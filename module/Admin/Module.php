<?php

/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 10-Mar-18
 * Time: 10:06 AM
 */
namespace Admin;

use Admin\Form\AccessForm;
use Admin\Form\CategoryForm;
use Admin\Form\VerifyForm;
use Admin\Model\MyAuth;
use Admin\View\Helper\Layout;
use Admin\View\Helper\Unicode;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Admin\Form\ProductForm;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $share = $eventManager->getSharedManager();
        $share->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function ($e) {

            $controller = $e->getTarget();

            $route = $e->getRouteMatch();
            $actionName = $route->getParam('action');

            //lây ra controller. kiểm tra xem ó có liên quan j với nhau k. và action phải khác logout
            if($controller instanceof Controller\VerifyController AND $actionName != "logout"){
                $controller->layout('layout/auth');
            }else{
                $sm = $e->getApplication()->getServiceManager();
//                $auth = $sm->get('ZendAuth');
                $plugin = $sm->get('ControllerPluginManager')->get('ThaiDuc\Controller\Plugin\AclPlugin');
                $plugin->RoleAccess($e);
                $response = $e->getResponse();
                if($response->getStatusCode() == 302){
                    $e->stopPropagation();
                    $controller->plugin('redirect')->toRoute('admin/verify',['action' => 'denied']);
                }
                /*
                if (!$auth->hasIdentity()) {
                    $controller->plugin('redirect')->toRoute('admin/verify',['action' => 'login']);
                }
                */
            }
            // độ ưu tiên, k cần view vẫn chạy
        },99);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig(){
        return array(
            'factories' => array(
                'Layout' => function($sm){
                    $helper = new Layout($sm);
                    return $helper;
                },
                'Unicode' => function($sm){
                    $helper = new Unicode($sm);
                    return $helper;
                }
            )
        );
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/router.config.php'
        );

    }

    public function getFormElementConfig(){
        return array(
            'factories' => array(
                'ProductForm' => function($sm){
                    $form = new ProductForm('Product_Form');
                    return $form;
                },
                'VerifyForm' => function($sm){
                    $form = new VerifyForm('Verify_Form');
                    return $form;
                },
                'CategoryForm' => function($sm){
                    $form = new CategoryForm('Category_Form');
                    return $form;
                },
                'AccessForm' => function($sm){
                    $form = new AccessForm('Access_Form');
                    return $form;
                }
            ),
        );
    }

    public function getServiceConfig(){
        return array(
            'invokables' => array(
                'ProductManager'    => 'Admin\Service\ProductManager',
                'CategoryManager'   => 'Admin\Service\CategoryManager',
                'UnitManager'       => 'Admin\Service\UnitManager',
                'UserManager'       => 'Admin\Service\UserManager',
            ),
            'factories' => [
                'ZendAuth' => function ($sm) {
                    // If you are using DoctrineORMModule:
                    return $sm->get('doctrine.authenticationservice.orm_default');
                    // If you are using DoctrineODMModule:
//                    return $sm->get('doctrine.authenticationservice.odm_default');
                },
                'MyAuth' => function($sm){
                    $auth = new MyAuth();
                    return $auth;
                }
            ],
        );
    }
}
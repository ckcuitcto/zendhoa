<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 14-Mar-18
 * Time: 2:07 AM
 */

namespace Admin\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class VerifyController extends AbstractActionController
{
    public function indexAction()
    {
        $sm = $this->getServiceLocator();
        $authService  = $sm->get('ZendAuth');

        if ($authService->hasIdentity()) {
            $authInfo = $authService->getIdentity();
            echo "<pre>";
            print_r($authInfo);
            echo "</pre>";

        } else {
            $this->flashMessenger()->addMessage('Vui lòng đăng nhập để truy cập vào hệ thống');
            return $this->redirect()->toRoute('admin/verify');
            // not logged in
        }
       return false;
    }

    public function loginAction(){
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('VerifyForm');

        $error = "";
        $flash = $this->flashMessenger()->getMessages();

        $request = $this->getRequest();
        if($request->isPost()){
            $dataInput = $request->getPost();
            $form->addInputFiltersLogin();
            $form->setData($dataInput);
            if($form->isValid()){
                $dataValid = $form->getData();
                $authService  = $sm->get('ZendAuth');

                $authAdapter = $authService->getAdapter();
                $authAdapter->setIdentity($dataValid['email']);
                $authAdapter->setCredential($dataValid['password']);
                $authResult = $authService->authenticate();

                if ($authResult->isValid()) {
                    $identity = $authResult->getIdentity();
                    $authService->getStorage()->write($identity);
                    return $this->redirect()->toRoute('admin/product');
                }else{
                    $error = 'Your authentication credentials are not valid';
                }
            }
        }
        return new ViewModel(array('form'=>$form,'error'=>$error,'flash' => $flash));
    }

    public function logoutAction(){
        $sm = $this->getServiceLocator();
        $authService = $sm->get('ZendAuth');
        $authService->clearIdentity();

        $this->flashMessenger()->addMessage('Đăng xuất thành công');
        return $this->redirect()->toRoute('admin/verify', array('action' => 'login'));
    }
}
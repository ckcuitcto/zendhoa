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
use Zend\Mail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class VerifyController extends AbstractActionController
{
    protected $myAuth;
    protected $authService;
    protected $reCaptcha;
    protected $smtp;

    public function getMyAuth()
    {
        if (empty($this->myAuth)) {
            $this->myAuth = $this->getServiceLocator()->get('MyAuth');
        }
        return $this->myAuth;
    }

    public function getAuthService()
    {
        if (empty($this->authService)) {
            $this->authService = $this->getServiceLocator()->get('ZendAuth');
        }
        return $this->authService;
    }

    public function getEntitymanager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }

    public function getReCaptcha()
    {
        if (empty($this->reCaptcha)) {
            $config = $this->getServiceLocator()->get('config');
            $this->reCaptcha = new \ZendService\ReCaptcha\ReCaptcha($config['recaptcha']['public'], $config['recaptcha']['private']);
        }
        return $this->reCaptcha;
    }

    public function getSMTPTransport()
    {
        if (!$this->smtp) {
            $config = $this->getServiceLocator()->get('config');
            $transport = new SmtpTransport();
            $options = new SmtpOptions(array(
                    'name' => 'smtp.gmail.com',
                    'host' => 'smtp.gmail.com',
                    'port' => 465,
                    'connection_class' => 'login',
                    'connection_config' => $config['smtp_config']
                )
            );
            $transport->setOptions($options);
            $this->smtp = $transport;
        }
        return $this->smtp;
    }

    public function indexAction()
    {
        $sm = $this->getServiceLocator();
        $authService = $sm->get('ZendAuth');

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

    public function loginAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('VerifyForm');

        $error = "";
        $flash = $this->flashMessenger()->getMessages();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $dataInput = $request->getPost();
            $form->addInputFiltersLogin();
            $form->setData($dataInput);
            if ($form->isValid()) {
                $dataValid = $form->getData();
                $authService = $sm->get('ZendAuth');

                $authAdapter = $authService->getAdapter();
                $authAdapter->setIdentity($dataValid['email']);
                $authAdapter->setCredential($dataValid['password']);
                $authResult = $authService->authenticate();

                if ($authResult->isValid()) {
                    if ($dataValid['remember'] == 1) {
                        $this->getMyAuth()->setRememberMe(1);
                        $authService->setStorage($this->getMyAuth());
                    }
                    $identity = $authResult->getIdentity();
                    $authService->getStorage()->write($identity);
                    return $this->redirect()->toRoute('admin/product');
                } else {
                    $error = 'Your authentication credentials are not valid';
                }
            }
        }
        return new ViewModel(array('form' => $form, 'error' => $error, 'flash' => $flash));
    }

    public function logoutAction()
    {
        $sm = $this->getServiceLocator();
        $authService = $sm->get('ZendAuth');
        $authService->clearIdentity();
        $this->getMyAuth()->forgetMe();

        $this->flashMessenger()->addMessage('Đăng xuất thành công');
        return $this->redirect()->toRoute('admin/verify', array('action' => 'login'));
    }

    public function forgotAction()
    {
        $em = $this->getEntitymanager();
        $sm = $this->getServiceLocator();
        $error = "";
        $mess = $this->flashMessenger()->getMessages();
        $form = $sm->get('FormElementManager')->get('VerifyForm');
        $form->get('submit')->setAttribute('value', 'Gửi');

        $captcha = $this->getReCaptcha();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $dataInput = $request->getPost();
            $form->setValidationGroup('email');
            $form->setData($dataInput);
            $resultCaptcha = $captcha->verify($dataInput['recaptcha_challenge_field'], $dataInput['recaptcha_response_field']);
            if ($form->isValid() AND $resultCaptcha->isValid()) {
                $dataValid = $form->getData();
                $userForgot = $em->getRepository('\Admin\Entity\User')->findOneBy(array('email' => $dataValid['email']));
                if ($userForgot) {
                    $date = date('Y-m-d H');
                    $activeCode = md5($userForgot->getName() . $date . $userForgot->getPassword());
                    $userName = $userForgot->getName();
                    $link = "http://localhost" . $this->url()->fromRoute('admin/verify', array('action' => 'active')) . "/$activeCode";

                    $config = $sm->get('config');
                    $emailFrom = $config['email_config']['forgot']['emailFrom'];
                    $nameFrom = $config['email_config']['forgot']['nameFrom'];

                    $sm->get('UserManager')->setRememberTokenByUser($userForgot, $activeCode);

                    $mail = new Mail\Message();
//                    $mail->setFrom($emailFrom,$nameFrom);
                    $mail->setFrom('hoasaigonn@gmail.com', 'abc');
                    $mail->addTo($userForgot->getEmail(), $userForgot->getName());
                    $mail->setSubject("Email khôi phục mật khẩu");
                    $body = "Chào bạn $userName
                    Liên kết phục hồi mật khẩu của bạn là $link
                    <br>
                    Liên kết chỉ có hiệu lực trong vòng 1 phút kể từ khi bạn gửi yêu cầu!!!.
                    ";
                    $mail->setBody($body);
                    $this->getSmtpTransport()->send($mail);

                    $mess = "Chúng tôi đã gửi email chứa liên kết phục hồi mật khẩu tới địa chỉ $dataValid[email]";

                } else {
                    $error = "Email không tồn tại";
                }
            } else {
                $error = 'Mã captcha không chính xác';
            }
        }

        return new ViewModel(['form' => $form, 'captcha' => $captcha, 'error' => $error, 'message' => $mess]);
    }

    public function activeAction()
    {

        $em = $this->getEntitymanager();
        $sm = $this->getServiceLocator();

        $code = $this->params()->fromRoute('code');
        $user = $em->getRepository('\Admin\Entity\User')->findOneBy(array('rememberToken' => $code));

        $date = date('Y-m-d H');

        if ($user){
            $activeCode = md5($user->getName() . $date . $user->getPassword());
            if($code==$activeCode) {
                $form = $sm->get('FormElementManager')->get('VerifyForm');
                $form->setValidationGroup('password','repassword');
                $form->addInputFiltersForgot();
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $dataInput = $request->getPost();
                    $form->setData($dataInput);
                    if ($form->isValid()) {
                        $dataValid = $form->getData();
                        $sm->get('UserManager')->changePassword($user,$dataValid['password']);
                        $this->flashMessenger()->addMessage('Đổi mật khẩu thành công');
                        return $this->redirect()->toRoute('admin/verify', array('action' => 'login'));
                    }
                }
            }else{
                $this->flashMessenger()->addMessage('Mã đã hết hạn');
                return $this->redirect()->toRoute('admin/verify', array('action' => 'forgot'));
            }
        }else{
            return $this->redirect()->toRoute('admin/verify', array('action' => 'forgot'));
        }
        return new ViewModel(['form' => $form, 'code' => $code]);
    }

    public function deniedAction(){
        return new ViewModel();
    }
}
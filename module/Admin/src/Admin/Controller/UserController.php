<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 10-Mar-18
 * Time: 10:34 AM
 */

namespace Admin\Controller;


use Zend\Paginator\Paginator;
use Zend\Serializer\Adapter\PhpSerialize;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class UserController extends MainController
{
    public function getEntitymanager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }

    public function indexAction()
    {

        $em = $this->getEntitymanager();
        $repositoryUser = $em->getRepository('\Admin\Entity\User');

        $page = (int)$this->params()->fromRoute('page', 1);
        $pagingConfig = array(
            'ItemCountPerPage' => 5,
            'CurrentPageNumber' => $page,
        );
        //lúc đầu thì dùng ntn. nếu tạo ra file repository thì dùng cái kia
//        $products = $repositoryProduct->findBy(array(),array('id' => 'DESC'));
//        $ormPaging = new ORMPaginator($repositoryProduct->createQueryBuilder('posts'));

        $users = $repositoryUser->getAll($pagingConfig);
        $ormPaging = new ORMPaginator($users);
        $adapter = new DoctrineAdapter($ormPaging);
        $paging = new Paginator($adapter);
        $paging->setDefaultItemCountPerPage($pagingConfig['ItemCountPerPage']);
        $paging->setCurrentPageNumber($pagingConfig['CurrentPageNumber']);

        $flash = $this->flashMessenger()->getMessages();
        return new ViewModel(array('users' => $paging, 'flash' => $flash));

    }

    public function listAction()
    {

        return new ViewModel();
    }

    public function addAction()
    {

        return new ViewModel();
    }

    public function editAction()
    {

        return new ViewModel();
    }

    public function accessAction()
    {
        $sm = $this->getServiceLocator();
        $em = $this->getEntitymanager();
        $serialize = new PhpSerialize();

        $idUser = $this->params()->fromRoute('id', 0);
        $user = $em->getRepository('\Admin\Entity\User')->findOneBy(array('id' => $idUser));
        if (!$idUser OR empty($user)) {
            return $this->redirect()->toRoute('admin/user', array('action' => 'index'));
        }

        $form = $sm->get('FormElementManager')->get('AccessForm');
        //set những quyền đã có vào form
        if(!empty($user->getAccess())){
            $access = $serialize->unserialize($user->getAccess());
            $this->setValueAccessForm($form,$access);
            echo "<pre>";
            print_r($access);
            echo "</pre>";
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $dataInput = $request->getPost()->toArray();
            // gỡ bỏ các phần k phải là mảng
            foreach ($dataInput as $key => $value) {
                if (!is_array($value)) {
                    unset($dataInput[$key]);
                }
            }

            //lưu quyền vào db ở dạng chuỗi
            $access['admin'] = $dataInput;
            $strAccess = $serialize->serialize($access);
            $sm->get('UserManager')->saveAccessByUserId($idUser,$strAccess);

            $userName = $user->getName();
            $this->flashMessenger()->addMessage("Phân quyền cho $userName thành công!");
            $this->redirect()->toRoute('admin/user',array('action'=>'index'));
        }

        return new ViewModel(['form' => $form, 'id' => $idUser, 'user' => $user]);
    }

    protected function setValueAccessForm($form,$access){
        foreach ($access['admin'] as $key => $value){
            $form->get($key."controller")->setValue($key);
            $form->get($key)->setValue($value);
        }
    }
}
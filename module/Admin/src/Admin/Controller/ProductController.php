<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 10-Mar-18
 * Time: 10:34 AM
 */

namespace Admin\Controller;


use Zend\Validator\File\MimeType;
use Zend\Validator\File\Size;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator;

class ProductController extends MainController
{
    public function __construct()
    {
        $config['authentication'] = function () {
            return isset($_SESSION['IsAuthorized']) && $_SESSION['IsAuthorized'];
        };
    }

    public function getEntitymanager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }

    public function getFileLocation()
    {
        $config = $this->getServiceLocator()->get('config');
        return $config['upload_location'];
    }

    public function indexAction()
    {
        $em = $this->getEntitymanager();
        $repositoryProduct = $em->getRepository('\Admin\Entity\Product');

        $page = (int)$this->params()->fromRoute('page', 1);
        $pagingConfig = array(
            'ItemCountPerPage' => 10,
            'CurrentPageNumber' => $page,
        );
        //lúc đầu thì dùng ntn. nếu tạo ra file repository thì dùng cái kia
//        $products = $repositoryProduct->findBy(array(),array('id' => 'DESC'));
//        $ormPaging = new ORMPaginator($repositoryProduct->createQueryBuilder('posts'));

        $products = $repositoryProduct->getAll($pagingConfig);
        $ormPaging = new ORMPaginator($products);
        $adapter = new DoctrineAdapter($ormPaging);
        $paging = new Paginator\Paginator($adapter);
        $paging->setDefaultItemCountPerPage($pagingConfig['ItemCountPerPage']);
        $paging->setCurrentPageNumber($pagingConfig['CurrentPageNumber']);

        $flash = $this->flashMessenger()->getMessages();
        return new ViewModel(array('products' => $paging, 'flash' => $flash));
    }

    public function addAction()
    {
        $sm = $this->getServiceLocator();
        $em = $this->getEntitymanager();
        $form = $sm->get('FormElementManager')->get('ProductForm');

        $categories = $em->getRepository('\Admin\Entity\Category')->findAll();
        $arrCate = array();
        foreach ($categories as $cate) {
            $arrCate[$cate->getId()] = $cate->getName();
        }
        $form->get('id_type')->setValueOptions($arrCate);

        $units = $em->getRepository('\Admin\Entity\Unit')->findAll();
        $arrUnit = array();
        foreach ($units as $unit) {
            $arrUnit[$unit->getId()] = $unit->getName();
        }
        $form->get('unit')->setValueOptions($arrUnit);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $dataInput = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $form->setData($dataInput);
            if ($form->isValid()) {
                $size = new Size(array('min' => '10KB', 'max' => '2MB'));
                $mime = new MimeType(array('image/jpg', 'image/gif', 'application/pdf', 'image/jpeg'));
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size, $mime), $dataInput['image']['name']);

                if ($adapter->isValid()) {
                    $adapter->setDestination($this->getFileLocation());
                    if ($adapter->receive($dataInput['image']['name'])) {

                        $dataValid = $form->getData();
                        $sm->get('ProductManager')->addProduct($dataValid);

                        $this->flashMessenger()->addMessage('Thêm sản phẩm thành công !');
                        $this->redirect()->toRoute('admin/product', array('action' => 'index'));
                    }
                }
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function editAction()
    {
        $sm = $this->getServiceLocator();
        $em = $this->getEntitymanager();

        $id = $this->params()->fromRoute('id', 0);
        $product = $em->getRepository('\Admin\Entity\Product')->findOneBy(array('id' => $id));

        if (!$id OR empty($product)) {
            return $this->redirect()->toRoute('admin/product', array('action' => 'index'));
        }

        $form = $sm->get('FormElementManager')->get('ProductForm');

        $formData = array(
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'unit_price' => $product->getUnitPrice(),
            'promotion_price' => $product->getPromotionPrice(),
            'image' => $product->getImage(),
            'new' => $product->getNew(),
            'quantity' => $product->getQuantity(),
            'view' => $product->getView(),
        );
        $form->setData($formData);

        $arrCate = $sm->get('CategoryManager')->getArrayCategory();
        $form->get('id_type')->setValueOptions($arrCate);
        $form->get('id_type')->setAttributes(array('value' => $product->getCategory()->getId(), 'selected' => true));

        $arrUnit = $sm->get('UnitManager')->getArrayUnit();
        $form->get('unit')->setValueOptions($arrUnit);
        $form->get('unit')->setAttributes(array('value' => $product->getUnit()->getId(), 'selected' => true));

        $form->getInputFilter()->get('image')->setRequired(false);

        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if($request->isPost()){
            $dataInput = $request->getPost();
            $form->setData($dataInput);
            if($form->isValid()){
                $dataValid = $form->getData();
                $sm->get('ProductManager')->editProduct($product,$dataValid);

                $this->flashMessenger()->addMessage('Sửa sản phẩm thành công !');
                $this->redirect()->toRoute('admin/product', array('action' => 'index'));
            }
        }
        return new ViewModel(array('form' => $form,'productId'=>$id));
    }

    public function deleteAction(){

        $em = $this->getEntitymanager();

        $id = $this->params()->fromRoute('id', 0);
        $product = $em->getRepository('\Admin\Entity\Product')->findOneBy(array('id' => $id));

        if (!$id OR empty($product)) {
            return $this->redirect()->toRoute('admin/product', array('action' => 'index'));
        }

        $em->remove($product);
        $em->flush();

        $this->flashMessenger()->addMessage("Xoá sản phẩm " . $product->getName() . " thành công !");
        return $this->redirect()->toRoute('admin/product', array('action'=>'index'));
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 10-Mar-18
 * Time: 10:34 AM
 */

namespace Admin\Controller;


use Zend\View\Model\ViewModel;

class CategoryController extends MainController
{
    public function getEntitymanager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }

    public function indexAction()
    {

        $em = $this->getEntitymanager();
        $categories = $em->getRepository('\Admin\Entity\Category')->findAll();

        return new ViewModel(array('categories' => $categories));
    }

    public function addAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('CategoryForm');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $dataInput = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $form->setData($dataInput);
            if($form->isValid()){
                $dataValid = $form->getData();
                $sm->get('CategoryManager')->addCategory($dataValid);
                $this->flashMessenger()->addMessage('Thêm thể loại thành công !');
                $this->redirect()->toRoute('admin/category', array('action' => 'index'));
            }
        }
        return new ViewModel(['form' => $form]);
    }

    public function editAction(){
        $sm = $this->getServiceLocator();
        $em = $this->getEntitymanager();
        $form = $sm->get('FormElementManager')->get('CategoryForm');

        $id = $this->params()->fromRoute('id');
        $category = $em->getRepository('\Admin\Entity\Category')->findOneBy(array('id'=>$id));

        $dataForm = [
            'name' => $category->getName(),
            'description' => $category->getDescription()
        ];
        $form->setData($dataForm);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $dataInput = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $form->setData($dataInput);
            $imageFilter = $form->getInputFilter()->get('image');
            $imageFilter->setRequired(false);
            if($form->isValid()){
                $dataValid = $form->getData();
                $sm->get('CategoryManager')->editCategory($category,$dataValid);
                $this->flashMessenger()->addMessage('Thêm thể loại thành công !');
                $this->redirect()->toRoute('admin/category', array('action' => 'index'));
            }
        }
        return new ViewModel(['form' => $form,'id'=>$id,'category'=>$category]);
    }

    public function deleteAction(){
        $em = $this->getEventManager();
//
//        $id = $this->params()->fromRoute('id', 0);
//        $product = $em->getRepository('\Admin\Entity\Category')->findOneBy(array('id' => $id));
//
//        if (!$id OR empty($product)) {
//            return $this->redirect()->toRoute('admin/category', array('action' => 'index'));
//        }
//
//        $em->remove($product);
//        $em->flush();
//
//        $this->flashMessenger()->addMessage("Xoá sản phẩm " . $product->getName() . " thành công !");
//        return $this->redirect()->toRoute('admin/product', array('action' => 'index'));
    }
}
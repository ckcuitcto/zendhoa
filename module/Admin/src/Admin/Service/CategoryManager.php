<?php

/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 12-Mar-18
 * Time: 3:50 PM
 */
namespace Admin\Service;

use Admin\Entity\Category;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class CategoryManager implements ServiceManagerAwareInterface
{
    private $sm;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->sm = $serviceManager;
    }

    public function getServiceLocator(){
        return $this->sm;
    }

    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }

    public function getArrayCategory(){
        $em = $this->getEntityManager();

        $categories = $em->getRepository('\Admin\Entity\Category')->findAll();
        $arrCate = array();
        foreach ($categories as $cate) {
            $arrCate[$cate->getId()] = $cate->getName();
        }
        return $arrCate;
    }

    public function addCategory($data){
        $em = $this->getEntityManager();
        $category = new Category();
        $category->setName($data['name']);
        $category->setDescription($data['description']);
        $category->setImage($data['image']);

        $em->persist($category);
        $em->flush();
    }

    public function editCategory($cate,$data){

        $em = $this->getEntityManager();

        $cate->setName($data['name']);
        $cate->setDescription($data['description']);

        if(!empty($data['image']['name'])){
            $cate->setImage($data['image']);
        }
        $current = date('Y-m-d H:i:s');
        $cate->setUpdateAt($current);

        $em->persist($cate);
        $em->flush();
    }

    public function removeCategory($cate){
        $em = $this->getEntityManager();
        $em->remove($cate);
        $em->flush();

    }
}
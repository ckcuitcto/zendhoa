<?php

/**
 * Created by PhpStorm.
 * User: Thai Duc
 * Date: 12-Mar-18
 * Time: 3:50 PM
 */

namespace Admin\Service;

use Admin\Entity\Product;
use Admin\Entity\ProductImage;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Validator\File\MimeType;
use Zend\Validator\File\Size;

class ProductManager implements ServiceManagerAwareInterface
{
    private $sm;

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->sm = $serviceManager;
    }

    public function getServiceLocator()
    {
        return $this->sm;
    }

    protected function getEntityManager()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        return $em;
    }

    public function addProduct($data)
    {
        $em = $this->getEntityManager();

        $category = $em->getRepository('\Admin\Entity\Category')->findOneBy(array('id' => $data['id_type']));
        $unit = $em->getRepository('\Admin\Entity\Unit')->findOneBy(array('id' => $data['unit']));

        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setUnitPrice($data['unit_price']);
        $product->setPromotionPrice($data['promotion_price']);
        $product->setImage($data['image']['name']);
        $product->setUnit($unit);
        $product->setNew($data['new']);
        $product->setQuantity($data['quantity']);
        $product->setView($data['view']);
        $product->setCategory($category);

        $current = date('Y-m-d H:i:s');
        $product->setCreatedAt($current);

        $this->addImageDetailsToProduct($product,$data['productImages']);

        $em->persist($product);
        $em->flush();
    }

    public function addImageDetailsToProduct($product,$data)
    {
        $em = $this->getEntityManager();

        foreach ($data as $image) {
            $imageDetail = new ProductImage();
            $imageDetail->setImage($image['name']);
            $imageDetail->setProduct($product);
            $imageDetail->setCreatedAt(date('Y-m-d H:i:s'));
            $em->persist($imageDetail);
        }

    }

    public function editProduct(Product $product, $data)
    {
        $em = $this->getEntityManager();

        $category = $em->getRepository('\Admin\Entity\Category')->findOneBy(array('id' => $data['id_type']));
        $unit = $em->getRepository('\Admin\Entity\Unit')->findOneBy(array('id' => $data['unit']));

        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setUnitPrice($data['unit_price']);
        $product->setPromotionPrice($data['promotion_price']);

        if (!empty($data['image'])) {
            $product->setImage($data['image']['name']);
        }
        $product->setUnit($unit);
        $product->setNew($data['new']);
        $product->setQuantity($data['quantity']);
        $product->setView($data['view']);
        $product->setCategory($category);

        echo "<pre>";
        print_r($data);
        print_r($data['productImages']);
        echo "</pre>";

        $current = date('Y-m-d H:i:s');
        $product->setUpdateAt($current);

        $this->addImageDetailsToProduct($product,$data['productImages']);

        $em->persist($product);
        $em->flush();
    }

}
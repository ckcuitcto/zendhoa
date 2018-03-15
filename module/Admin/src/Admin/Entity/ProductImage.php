<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Product;
/**
 * @ORM\Entity
 * @ORM\Table(name="product_images")
 */

 class ProductImage{
     /**
      * @ORM\Id
      * @ORM\Column(name="id");
      * @ORM\GeneratedValue 
      */
     protected $id;
     /**
      * @ORM\Column(name="image");
      */
     protected $image;
     /**
      * @ORM\Column(name="created_at");
      */
     protected $createdAt;

     /**
      * @ORM\Column(name="updated_at");
      */
     protected $updatedAt;

     /**
      * @ORM\ManyToOne(targetEntity="\Admin\Entity\Product",inversedBy="product_images")
      * @ORM\JoinColumn(name="id_product",referencedColumnName="id")
      */
     protected $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }
     /**
      * @param int $id
      */
     public function setId($id){
         $this->id = $id;
     }
     /**
      * @return integer
      */
     public function getId(){
         return $this->id;
     }

  /**
   * @param string $image
   */
    public function setImage($image){
      $this->image = $image;
    }
    /**
     * @return varchar
     */
    public function getImage(){
        return $this->image;
    }

    /**
   * @param string $createdAt
   */
    public function setCreatedAt($createdAt){
      $this->createdAt = $createdAt;
    }
    /**
     * @return varchar
     */
    public function getCreatedAt(){
        return $this->createdAt;
    }

    /**
   * @param string $updateAt
   */
    public function setUpdatedAt($updatedAt){
      $this->updatedAt = $updatedAt;
    }
    /**
     * @return varchar
      */
    public function getUpdatedAt(){
        return $this->updatedAt;
    }

     /**
      * @return array
      */
     public function getProduct(){
         return $this->product;
     }
     /**
      * set  Unit
      * @param Product $product
      */
     public function setProduct(Product $product){
         $this->product = $product;
     }
 }
<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Category;
/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="\Admin\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */

 class Product{
     /**
      * @ORM\Id
      * @ORM\Column(name="id");
      * @ORM\GeneratedValue 
      */
     protected $id;
     /**
      * @ORM\Column(name="name");
      */
     protected $name;
    
    /**
      * @ORM\Column(name="description");
      */
     protected $description;

      /**
      * @ORM\Column(name="unit_price");
      */
    protected $unitPrice;

    /**
      * @ORM\Column(name="promotion_price");
      */
    protected $promotionPrice;

     /**
      * @ORM\Column(name="image");
      */
     protected $image;

    /**
      * @ORM\Column(name="quantity");
      */
    protected $quantity;
    
    /**
      * @ORM\Column(name="view");
      */
    protected $view;

     /**
      * @ORM\Column(name="new");
      */
     protected $new;

     /**
      * @ORM\Column(name="created_at");
      */
     protected $createdAt;

     /**
      * @ORM\Column(name="updated_at");
      */
     protected $updatedAt;

     /**
     * @ORM\ManyToOne(targetEntity="\Admin\Entity\Category",inversedBy="products")
     * @ORM\JoinColumn(name="id_type",referencedColumnName="id")
     */
    protected $category;

     /**
      * @ORM\ManyToOne(targetEntity="\Admin\Entity\Unit",inversedBy="products")
      * @ORM\JoinColumn(name="unit",referencedColumnName="id")
      */
     protected $unit;

     /**
      *  @ORM\OneToMany(targetEntity="\Admin\Entity\ProductImage",mappedBy="product")
      *  @ORM\JoinColumn(name="id",referencedColumnName="id_product")
      */
     protected $productImages;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->unit = new ArrayCollection();
        $this->productImages = new ArrayCollection();
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
      * @param string $name
      */
      public function setName($name){
        $this->name = $name;
    }
    /**
     * @return varchar
     */
    public function getName(){
        return $this->name;
    }

     /**
      * @param string $description
      */
    public function setDescription($description){
      $this->description = $description;
    }
    /**
     * @return varchar
     */
    public function getDescription(){
        return $this->description;
    }

    /**
      * @param double $unitPrice
      */
    public function setUnitPrice($unitPrice){
      $this->unitPrice = $unitPrice;
    }
    /**
     * @return double
     */
    public function getUnitPrice(){
        return $this->unitPrice;
    }

    /**
      * @param int $promotionPrice
      */
    public function setPromotionPrice($promotionPrice){
      $this->promotionPrice = $promotionPrice;
    }
    /**
     * @return integer
     */
    public function getPromotionPrice(){
        return $this->promotionPrice;
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
   * @param integer $new
   */
    public function setNew($new){
      $this->new = $new;
    }
    /**
     * @return integer 
     */
    public function getNew(){
        return $this->new;
    }

    /**
   * @param integer $quantity
   */
    public function setQuantity($quantity){
      $this->quantity = $quantity;
    }
    /**
     * @return integer 
     */
    public function getQuantity(){
        return $this->quantity;
    }


    /**
   * @param integer $view
   */
    public function setView($view){
      $this->view = $view;
    }
    /**
     * @return integer 
     */
    public function getView(){
        return $this->view;
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
    public function setUpdateAt($updateAt){
      $this->updateAt = $updateAt;
    }
    /**
     * @return varchar
   */
    public function getUpdateAt(){
        return $this->updateAt;
    }

    /**
     * @return array
   */
    public function getCategory(){
      return $this->category;
    }
     /**
      * set  Cate
      * @param Category $cate
      */
     public function setCategory(Category $cate){
         $this->category = $cate;
     }

     /**
      * @return array
      */
     public function getUnit(){
         return $this->unit;
     }
     /**
      * set  Unit
      * @param Unit $unit
      */
     public function setUnit(Unit $unit){
         $this->unit = $unit;
     }

     public function getImageDetails(){
         return $this->productImages;
     }

     public function setImageDetails($productImages){
         $this->productImages[] = $productImages;
     }
 }
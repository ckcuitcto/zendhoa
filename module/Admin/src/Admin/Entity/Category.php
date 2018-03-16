<?php

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Admin\Entity\Product;
/**
 * @ORM\Entity
 * @ORM\Table(name="type_products")
 */

 class Category{
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
     *  @ORM\OneToMany(targetEntity="\Admin\Entity\Product",mappedBy="category")
     *  @ORM\JoinColumn(name="id",referencedColumnName="id_type")
     */
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();

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
    *
    */

    public function getProducts(){
      return $this->products;
    }
 }
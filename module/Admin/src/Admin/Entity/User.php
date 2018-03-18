<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="\Admin\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User
{
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
     * @ORM\Column(name="password");
     */
    protected $password;

    /**
     * @ORM\Column(name="email");
     */
    protected $email;

    /**
     * @ORM\Column(name="gender");
     */
    protected $gender;

    /**
     * @ORM\Column(name="level");
     */
    protected $level;

    /**
     * @ORM\Column(name="address");
     */
    protected $address;

    /**
     * @ORM\Column(name="phone_number");
     */
    protected $phoneNumber;

    /**
     * @ORM\Column(name="birthday");
     */
    protected $birthday;

    /**
     * @ORM\Column(name="note");
     */
    protected $note;

    /**
     * @ORM\Column(name="created_at");
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at");
     */
    protected $updatedAt;

    /**
     * @ORM\Column(name="remember_token");
     */
    protected $rememberToken;

    /**
     * @ORM\Column(name="access");
     */
    protected $access;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return varchar
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return varchar
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return varchar
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return varchar
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return varchar
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $birthDay
     */
    public function setBirthday($birthDay)
    {
        $this->birthday = $birthDay;
    }

    /**
     * @return varchar
     */
    public function getBirthday()
    {
        return $this->birthday;
    }


    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return varchar
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $updateAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return varchar
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return varchar
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $rememberToken
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;
    }

    /**
     * @return varchar
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * @param string $access
     */
    public function setAccess($access)
    {
        $this->access = $access;
    }

    /**
     * @return varchar
     */
    public function getAccess()
    {
        return $this->access;
    }
}
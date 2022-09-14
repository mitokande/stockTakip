<?php
namespace Entities;

class User {
    public $id;
    public $username;
    public $userToken;
    public $email;
    public $shopName;
    public $userStockId;
    public $userOrderId;
    public $tokenExpiry;
    public $shopCategory;
    public $shopCategoryFormId;

    public function __construct($id,$username,$userToken,$email,$shopName,$tokenExpiry,$userOrderId,$userStockId,$shopCategory,$shopCategoryFormId)
    {
        $this->id = $id;
        $this->username = $username;
        $this->userToken = $userToken;
        $this->email = $email;
        $this->shopName = $shopName;
        $this->tokenExpiry = $tokenExpiry;
        $this->userStockId = $userStockId;
        $this->userOrderId = $userOrderId;
        $this->shopCategory = $shopCategory;
        $this->shopCategoryFormId = $shopCategoryFormId;
        
    }


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUserToken()
    {
        return $this->userToken;
    }

    /**
     * @param mixed $userToken
     */
    public function setUserToken($userToken)
    {
        $this->userToken = $userToken;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getShopName()
    {
        return $this->shopName;
    }

    /**
     * @param mixed $shopName
     */
    public function setShopName($shopName)
    {
        $this->shopName = $shopName;
    }

    /**
     * @return mixed
     */
    public function getTokenExpiry()
    {
        return $this->tokenExpiry;
    }

    /**
     * @param mixed $tokenExpiry
     */
    public function setTokenExpiry($tokenExpiry)
    {
        $this->tokenExpiry = $tokenExpiry;
    }

    /**
     * @return mixed
     */
    public function getUserOrderId()
    {
        return $this->userOrderId;
    }

    /**
     * @param mixed $userOrderId
     */
    public function setUserOrderId($userOrderId): void
    {
        $this->userOrderId = $userOrderId;
    }

    /**
     * @return mixed
     */
    public function getUserStockId()
    {
        return $this->userStockId;
    }

    /**
     * @param mixed $userOrderId
     */
    public function setUserStockId($userStockId): void
    {
        $this->userStockId = $userStockId;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    public function getCategoryFormId(){
        return $this->shopCategoryFormId;
    }
}
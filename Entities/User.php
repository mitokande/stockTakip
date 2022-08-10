<?php
class User extends Table {
    private $username;
    private $userToken;
    private $email;
    private $shopName;
    private $tokenExpiry;

    public function __construct($username,$userToken,$email,$shopName,$tokenExpiry,$shopName,$tokenExpiry,$userOrderId,$userStockId)
    {
        $this->username = $username;
        $this->userToken = $userToken;
        $this->email = $email;
        $this->shopName = $shopName;
        $this->tokenExpiry = $tokenExpiry;
        parent::__constructor($userOrderId,$userStockId);
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

    public function current_user()
    {

    }
}
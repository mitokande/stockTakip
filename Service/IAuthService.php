<?php
require_once("AuthManager.php");
require_once("Entities/User.php");
interface IAuthService{

    public function login($username,$password);

    public function register($username,$email,$password,$shopName);

    public function verifyUserToken($token) : User;

    public function currentUser() : User;

}
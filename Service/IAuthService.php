<?php
require_once("AuthManager.php");
require_once("Entities/User.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/Result.php");
require_once("Utilities/Result/SuccessResult.php");
require_once("Utilities/Result/DataResult.php");
require_once("Utilities/Result/ErrorDataResult.php");
require_once("Utilities/Result/SuccessDataResult.php");
interface IAuthService{

    public function login($username,$password) : Result;

    public function register($username,$email,$password,$shopName) : DataResult;

    public function verifyUserToken($token) : DataResult;

    public function updateUserToken(User $user) : DataResult;

    public function currentUser() : User;

}
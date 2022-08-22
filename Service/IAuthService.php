<?php
namespace Service;
require_once("vendor/autoload.php");

use Entities\User;
use Utilities\Result\DataResult;
use Utilities\Result\Result;

interface IAuthService {

    public function login($username,$password) : Result;

    public function register($username,$email,$password,$shopName) : DataResult;

    public function verifyUserToken($token) : DataResult;

    public function updateUserToken(User $user) : DataResult;

    public function currentUser() : User;

}
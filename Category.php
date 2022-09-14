<?php
require_once("vendor/autoload.php");

use Controllers\CategoryController;
use Service\AuthManager;

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Token,Origin, X-Requested-With, Content-Type, Accept');
require_once("ApiConfig.php");

$categoryController = new CategoryController();
$authManager = new AuthManager();
$token = getallheaders()['Token'];
$result = $authManager->verifyUserToken($token);
if ($result->success) {
    $user = $result->data;
    $categoryFormId = $user->getCategoryFormId();
    if(isset($_POST['categoryName'])){
        echo json_encode($categoryController->addCategory($categoryFormId,$_POST['categoryName']));
        exit();
    }else{
        echo json_encode($categoryController->getCategories($categoryFormId));
        exit(); 
    }
}
echo json_encode($result);


?>
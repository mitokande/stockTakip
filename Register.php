<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Token,Origin, X-Requested-With, Content-Type, Accept');
require_once("ApiConfig.php");
require_once("Utilities/DependencyResolver/AbstractFactory/Factory.php");

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON
header("Content-Type: application/json; charset=utf-8");

$email = $input["email"];
$username = $input["username"];
$password = $input["password"];
$shop_name = $input["shop_name"];

$factory = Factory::getInstance();
$result = $factory->createAuthManager()->register($username,$email,$password,$shop_name);
echo json_encode($result);
return;
?>
<?php
require_once("vendor/autoload.php");

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Token,Origin, X-Requested-With, Content-Type, Accept');
require_once("ApiConfig.php");

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON
header("Content-Type: application/json; charset=utf-8");

$username = $input["username"];
$password = $input["password"];
$factory = \Utilities\DependencyResolver\AbstractFactory\Factory::getInstance();
$result = $factory->createAuthManager()->login($username,$password);
if ($result->success)
{
    //http_response_code(200);
    echo json_encode($result);
    return;
}
//http_response_code(400);
echo json_encode($result);
return;

?>
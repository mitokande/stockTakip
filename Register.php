<?php
require_once("ApiConfig.php");
require_once("Service/AuthManager.php");

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON

$email = $input["email"];
$username = $input["username"];
$password = $input["password"];
$shop_name = $input["shop_name"];

$authManager = new AuthManager();
$result = $authManager->register($username,$email,$password,$shop_name);
if ($result->success)
{
    http_response_code(200);
    return;
}
http_response_code(400);
json_encode($result);
return;
?>
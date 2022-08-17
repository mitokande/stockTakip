<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
require_once("ApiConfig.php");
require_once("Service/AuthManager.php");
$inputJSON = file_get_contents('php://input');
echo json_decode($inputJSON, TRUE);
/*
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON

$username = $input["username"];
$password = $input["password"];
$authManager = AuthManager::getInstance();
$result = $authManager->login($username,$password);
if ($result->success)
{
    http_response_code(200);
    echo json_encode($result);
    return;
}
http_response_code(400);
echo json_encode($result);
return;*/

?>
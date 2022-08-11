<?php
require_once("ApiConfig.php");
require_once("Service/AuthManager.php");

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON

$username = $input["username"];
$password = $input["password"];
$authManager = new AuthManager();

echo json_encode($authManager->login($username,$password)[1]);
echo "\n";
echo($authManager->currentUser()->getEmail())

?>
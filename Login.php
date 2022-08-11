<?php
require_once("ApiConfig.php");
require_once("Service/AuthManager.php");

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON

$username = $input["username"];
$password = $input["password"];
$authManager = new AuthManager();
$result = $authManager->login($username,$password);
if ($result[0])
{
    echo json_encode($result[1]);
    return;
}
echo "Invalid User";
//echo($authManager->currentUser()->getEmail())

?>
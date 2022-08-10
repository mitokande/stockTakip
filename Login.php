<?php
require_once("ApiConfig.php");

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON

$username = $input["username"];
$password = $input["password"];

$response = $jotformAPI->getFormSubmissions("222212597595058");
$result = verifyUserAndPassword($response,$username,$password);
if ($result)
{
    echo json_encode("Logged In Successfully");
    return;
}
echo json_encode("Invalid Credentials");
return;
function verifyUserAndPassword($response,$username,$password)
{
    foreach ($response as $item) {
        if($item["answers"][5]["answer"] == $username &&  password_verify($password,$item["answers"][6]["answer"]) && $item['status'] == "ACTIVE")
        {
            return true;
        }
    }
    return false;
}
?>
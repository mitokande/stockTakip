<?php
require_once("ApiConfig.php");
require_once("Actions.php");

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON

$email = $input["email"];
$username = $input["username"];
$password = $input["password"];
$shop_name = $input["shop_name"];
$userToken = password_hash("JOTFORM_VERY_VERY_SECRET_KEY,${email}",PASSWORD_BCRYPT);
$expiry = Date('Y-m-d h:i:s', strtotime('+14 days'));

$response = $jotformAPI->getFormSubmissions("222212597595058");
$result = checkUserExist($response,$username,$email);
if ($result)
{
    $response = $jotformAPI->createFormSubmission("222212597595058",[
        "5" => $username,
        "6" => password_hash($password,PASSWORD_BCRYPT),
        "7" => $email,
        "8" => $shop_name,
        "9" => $userToken,
        "11" => $expiry
    ]);
    $stockFromId = cloneStockForm($jotformAPI);
    insertStockFormID($jotformAPI,$response['submissionID'],$stockFromId);

    $orderFromId = cloneOrderForm($jotformAPI);
    insertOrderFormID($jotformAPI,$response['submissionID'],$orderFromId);

}
function checkUserExist($response,$username,$email)
{
    foreach ($response as $item) {
        if($item['status'] == "ACTIVE"){
            if($item["answers"][5]["answer"] == $username )
        {
            echo json_encode("This username already registered");
            return false;
        }
        elseif ($item["answers"][7]["answer"] == $email)
        {
            echo json_encode("This email already registered");
            return false;
        }
        }
    }
    return true;
}
?>
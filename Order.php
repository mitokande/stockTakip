<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
require_once("Controllers/OrderController.php");

$orderController = new OrderController();
$orderInputJSON = file_get_contents('php://input');
$orderInput = json_decode($orderInputJSON, TRUE); //convert JSON

if($orderInput != null){
    $authManager = new AuthManager();
    $result = $authManager->verifyUserToken(getallheaders()['Token']);
    if ($result->success)
    {
        $user = $result->data;
        $orderFormId = $user->getUserOrderId();
        // echo $orderFormId;
        echo json_encode($orderController->addOrder(getApi(),$orderFormId,$orderInput));
        exit();
    }
    echo json_encode($result);
    return;
}

if(isset($_POST['addOrder'])){
    
}
    $authManager = new AuthManager();
    $token = getallheaders()['Token'];
    $result = $authManager->verifyUserToken($token);
    if ($result->success)
    {
        $user = $result->data;
        $orderFormId = $user->getUserOrderId();
        echo json_encode($orderController->getOrders(getApi(),$orderFormId));
        exit();
    }
    echo json_encode($result);
    return;

?>
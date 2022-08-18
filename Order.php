<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Token,Origin, X-Requested-With, Content-Type, Accept');
require_once("Controllers/OrderController.php");
require_once("Service/AuthManager.php");
$orderController = new OrderController();
$orderInputJSON = file_get_contents('php://input');
$orderInput = json_decode($orderInputJSON, TRUE); //convert JSON
header("Content-Type: application/json; charset=utf-8");

if($orderInput != null){
    $authManager = new AuthManager();
    $token = getallheaders()['Token'];
    $result = $authManager->verifyUserToken($token);
    if ($result->success)
    {
        $user = $result->data;
        $orderFormId = $user->getUserOrderId();
        $stockFormID = $user->getUserStockId();

        echo json_encode($orderController->addOrder(getApi(),$orderFormId,$orderInput,$stockFormID));
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
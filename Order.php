<?php
require_once("vendor/autoload.php");

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Token,Origin, X-Requested-With, Content-Type, Accept');

$orderController = new Controllers\OrderController();
$orderInputJSON = file_get_contents('php://input');
$orderInput = json_decode($orderInputJSON, TRUE); //convert JSON
header("Content-Type: application/json; charset=utf-8");
$factory = \Utilities\DependencyResolver\AbstractFactory\Factory::getInstance();

if($orderInput != null){

    $token = getallheaders()['Token'];
    $result = $factory->createAuthManager()->verifyUserToken($token);
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

    $authManager = new Service\AuthManager();
    $token = getallheaders()['Token'];
    $result = $factory->createAuthManager()->verifyUserToken($token);
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
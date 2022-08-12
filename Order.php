<?php 

require_once("Controllers/OrderController.php");
$orderController = new OrderController();

if(isset($_POST['addOrder'])){
    $authManager = new AuthManager();
    $user = $authManager->verifyUserToken($_POST['token']);
    $orderFormId = $user->getUserOrderId();
    echo $orderFormId;
    $orderController->addOrder(getApi(),$orderFormId);
}else if(isset($_POST['orders'])){
    $authManager = new AuthManager();
    $user = $authManager->verifyUserToken($_POST['token']);
    $orderFormId = $user->getUserOrderId();
    $orderController->getOrders(getApi(),$orderFormId);
}else{
    echo json_encode("Invalid request");
    exit();
}
?>
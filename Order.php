<?php 

require_once("OrderController.php");
$orderController = new OrderController();

if(isset($_POST['addOrder'])){
    $authManager = new AuthManager();
    $result = $authManager->verifyUserToken($_POST['token']);
    if ($result->success)
    {
        $user = $result->data;
        $orderFormId = $user->getUserOrderId();
        echo $orderFormId;
        $orderController->addOrder(getApi(),$orderFormId);
    }
    echo json_encode($result);
    return;
}else if(isset($_POST['orders'])){
    $authManager = new AuthManager();
    $result = $authManager->verifyUserToken($_POST['token']);
    if ($result->success)
    {
        $user = $result->data;
        $orderFormId = $user->getUserOrderId();
        $orderController->getOrders(getApi(),$orderFormId);
    }
    echo json_encode($result);
    return;
}else{
    echo json_encode("Invalid request");
    exit();
}
?>
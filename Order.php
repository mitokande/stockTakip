<?php 

require_once("Controllers/OrderController.php");
$orderController = new OrderController();

if(isset($_POST['addOrder'])){
    $authManager = new AuthManager();
    $result = $authManager->verifyUserToken($_POST['token']);
    if ($result->success)
    {
        $user = $result->data;
        $orderFormId = $user->getUserOrderId();
        // echo $orderFormId;
        echo json_encode($orderController->addOrder(getApi(),$orderFormId));
        exit();
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
        echo json_encode($orderController->getOrders(getApi(),$orderFormId));
        exit();
    }
    echo json_encode($result);
    return;
}else{
    echo json_encode("Invalid request");
    exit();
}
?>
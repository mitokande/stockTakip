<?php 
require_once("Controllers/StockController.php");

$stockController = new StockController();

if(isset($_POST['addStock'])){

    $authManager = new AuthManager();
    $result = $authManager->verifyUserToken($_POST['token']);
    if ($result->success)
    {
        $user = $result->data;
        $stockFormID = $user->getUserStockId();
        echo json_encode($stockController->AddStock($stockFormID));
        exit();
    }
    echo json_encode($result);
    return;
}else if(isset($_POST['stocks'])){
    $authManager = new AuthManager();
    $result = $authManager->verifyUserToken($_POST['token']);
    if ($result->success)
    {
        $user = $result->data;
        $stockFormID = $user->getUserStockId();
        echo json_encode($stockController->getStocks($stockFormID));
        exit();
    }
    return json_encode($result);
    return;
}else{
    echo json_encode("Invalid request");
    exit();
}

?>
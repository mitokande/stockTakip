<?php 
require_once("StockController.php");

$stockController = new StockController();

if(isset($_POST['addStock'])){

    $authManager = new AuthManager();
    $user = $authManager->verifyUserToken($_POST['token']);
    $stockFormID = $user->getUserStockId();
    $stockController->AddStock($stockFormID);
}else if(isset($_POST['stocks'])){
    $authManager = new AuthManager();
    $user = $authManager->verifyUserToken($_POST['token']);
    $stockFormID = $user->getUserStockId();
    $stockController->getStocks($stockFormID);
}else{
    echo json_encode("Invalid request");
    exit();
}

?>
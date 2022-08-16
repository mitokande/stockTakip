<?php 
require_once("ApiConfig.php");
require_once("Controllers/StockController.php");

$stockController = new StockController();
$stockInputJSON = file_get_contents('php://input');
$stockInput = json_decode($stockInputJSON, TRUE); //convert JSON
echo getallheaders()["Token"];
if($stockInput != null){

    $authManager = new AuthManager();
    $result = $authManager->verifyUserToken(getallheaders()['token']);
    if ($result->success)
    {
        $user = $result->data;
        $stockFormID = $user->getUserStockId();
        echo json_encode($stockController->AddStock(getApi(),$stockFormID,$stockInput));
        exit();
    }
    echo json_encode($result);
    return;
}
    $authManager = new AuthManager();
    $token = getallheaders()['token'];
    $result = $authManager->verifyUserToken($token);
    if ($result->success)
    {
        $user = $result->data;
        $stockFormID = $user->getUserStockId();
        echo json_encode($stockController->getStocks($stockFormID));
        exit();
    }
    echo json_encode($result);


?>
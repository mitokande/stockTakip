<?php
require_once("vendor/autoload.php");
use Controllers\StockController;
use Service\AuthManager;

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Token,Origin, X-Requested-With, Content-Type, Accept');
require_once("ApiConfig.php");

$stockController = new StockController();
$stockInputJSON = file_get_contents('php://input');
$stockInput = json_decode($stockInputJSON, TRUE); //convert JSON
header("Content-Type: application/json; charset=utf-8");

if($stockInput != null){

    $authManager = new AuthManager();
    $result = $authManager->verifyUserToken(getallheaders()['Token']);
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
$token = getallheaders()['Token'];
$result = $authManager->verifyUserToken($token);
if ($result->success)
{
    $user = $result->data;
    $stockFormID = $user->getUserStockId();
    echo json_encode($stockController->getStocks($stockFormID));
    exit();
}
return json_encode($result);


?>
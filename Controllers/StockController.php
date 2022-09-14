<?php
namespace Controllers;
require_once("vendor/autoload.php");
use Entities\Product;
use Service\AuthManager;
use Utilities\Result\DataResult;
use Utilities\Result\ErrorDataResult;
use Utilities\Result\SuccessDataResult;
require_once("ApiConfig.php");


class StockController
{
    function checkBarcode($jotformAPI, $barcode): DataResult
    {
        $barcodeTable = $jotformAPI->getFormSubmissions("222211745912045");

        foreach ($barcodeTable as $item) {
            if ($item['status'] == "ACTIVE" && $item['answers'][4]['answer'] == $barcode) {
                $urun = new Product;
                $urun->urunAdi = $item['answers'][3]['answer'];
                $urun->barcode = $item['answers'][4]['answer'];
                $urun->resim = $item['answers'][9]['answer'];
                $urun->fiyat = $item['answers'][8]['answer'];
                $urun->category = $item['answers'][16]['answer'];

            }
        }
        return new SuccessDataResult($urun, "Barcode found successfully");
        exit();


        return new ErrorDataResult(null, "Barcode does not exist in Table");
    }

    function addStock($jotformAPI, $stockFormID, $stockInput): DataResult
    {
        $stockTable = getApi()->getFormSubmissions($stockFormID);
        $added = [];
        foreach ($stockInput as $stock) {
            foreach ($stockTable as $item) {
                if ($item['status'] == "ACTIVE" && $item['answers'][6]['answer'] == $stock['barcode']) {
                    $valA = intval($item['answers'][7]['answer']);
                    $valB = intval($stock['stok']);
                    $result = getApi()->editSubmission($item['id'], array(
                        '7' => $valA + $valB
                    ));
                    $added[] = $stock['barcode'];
                }
            }

            if (in_array($stock['barcode'], $added)) {
                continue;
            }
            $image = $this->checkBarcode($jotformAPI, $stock['barcode'])->data->resim;
            $authManager = new AuthManager();
            $user = $authManager->verifyUserToken(getallheaders()['Token'])->data;

            $submission = array(
                "5" => $stock['urunAdi'],
                "6" => $stock['barcode'],
                "7" => $stock['stok'],
                "8" => $stock['fiyat'],
                "14" => $image,
                "15" => $user->shopName,
                "13" => $user->email,
                "16" => $stock['category']
            );

            // $result = $jotformAPI->createFormSubmission("222202437411037", $submission);
            $result = getApi()->createFormSubmission($stockFormID, $submission);
        }


        return new SuccessDataResult($result, "Stock added Successfuly");
    }





function getStocks($stockFormId) : DataResult
{
    $stockTable = getApi()->getFormSubmissions($stockFormId);
    $stocks = [];
    foreach($stockTable as $item){
        if($item['status'] == "ACTIVE"){
            $urun = new Product;
            $urun->urunAdi = $item['answers'][5]['answer'];
            $urun->barcode = $item['answers'][6]['answer'];
            $urun->resim = $item['answers'][14]['answer'];
            $urun->fiyat = $item['answers'][8]['answer'];
            $urun->adet = $item['answers'][7]['answer'];
            $urun->date = $item['created_at'];
            $urun->category = $item['answers'][16]['answer'];
            $stocks[] = $urun;
        }
    }
    $result = new SuccessDataResult($stocks,"Stocks listed successfuly");
    return $result;

    }
}


?>
<?php
namespace Controllers;
use Entities\CurrentUser;
use Entities\Product;
use Utilities\Result\DataResult;
use Utilities\Result\ErrorDataResult;
use Utilities\Result\SuccessDataResult;
require_once("vendor/autoload.php");
require_once("ApiConfig.php");
class OrderController
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

    public function sayHello(): string
    {
        return "Hello World";
    }

    function addOrder($jotformAPI, $orderFormId, $orderInput, $stockFormID): DataResult
    {
        $stockTable = getApi()->getFormSubmissions($stockFormID);

        foreach ($orderInput as $order) {
            foreach ($stockTable as $item) {
                if ($item['status'] == "ACTIVE" && $item['answers'][6]['answer'] == $order['barcode']) {
                    $valA = intval($item['answers'][7]['answer']);
                    $valB = intval($order['adet']);
                    $result = getApi()->editSubmission($item['id'], array(
                        '7' => $valA - $valB
                    ));
                }
            }
            $image = $this->checkBarcode($jotformAPI, $order['barcode'])->data->resim;

            $user = CurrentUser::$user;
            $submission = array(
                "5" => $order['urunAdi'],
                "6" => $order['barcode'],
                "7" => $order['adet'],
                "8" => $order['fiyat'],
                "15" => $image,
                "14" => $user->shopName,
                "13" => $user->email,
                "16" => $order['category']
            );
            $result = $jotformAPI->createFormSubmission($orderFormId, $submission);
        }


        return new SuccessDataResult($result, "Order added successfully");
    }

    function imageUpload()
    {
        $image_file = $_FILES["image"];

        // Exit if no file uploaded
        if (!isset($image_file)) {
            die('No file uploaded.');
        }

        // Exit if is not a valid image file
        $image_type = exif_imagetype($image_file["tmp_name"]);
        if (!$image_type) {
            die('Uploaded file is not an image.');
        }

        // Move the temp image file to the images/ directory
        if (move_uploaded_file($image_file["tmp_name"], "images/" . $image_file["name"])) {
            return "images/" . $image_file["name"];
        }
    }

    function getOrders($jotformAPI, $orderFormId): DataResult
    {
        $orderTable = getApi()->getFormSubmissions($orderFormId);
        $orders = [];
        foreach ($orderTable as $item) {
            if ($item['status'] == "ACTIVE") {
                $urun = new Product;
                $urun->urunAdi = $item['answers'][5]['answer'];
                $urun->barcode = $item['answers'][6]['answer'];
                $urun->resim = $item['answers'][15]['answer'];
                $urun->fiyat = $item['answers'][8]['answer'];
                $urun->adet = $item['answers'][7]['answer'];
                $urun->date = $item['created_at'];
                $urun->category = $item['answers'][16]['answer'];
                $orders[] = $urun;
            }
        }
        $result = new SuccessDataResult($orders, "Orders listed successfully");
        return $result;
        exit();
    }
}

?>
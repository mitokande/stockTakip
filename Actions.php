<?php 

if(isset($_POST['addStock'])){
    addStock($jotformAPI);
}

function cloneStockForm($jotformAPI){
    $result = $jotformAPI->cloneForm("222202437411037");
    return $result['id'];
}
function cloneOrderForm($jotformAPI){
    $result = $jotformAPI->cloneForm("222211450234035");
    return $result['id'];
}


function insertStockFormID($jotformAPI,$submissionID,$stockFormID){
    $result = $jotformAPI->editSubmission($submissionID, array(
        "3" => $stockFormID,
    ));
    return $result;
}
function insertOrderFormID($jotformAPI,$submissionID,$orderFormID){
    $result = $jotformAPI->editSubmission($submissionID, array(
        "4" => $orderFormID,
    ));
    return $result;
}

function addStock($jotformAPI){
    
    $submission = array(
        "5" => $_POST['urunAdi'],
        "6" => $_POST['barcode'],
        "7" => $_POST['stok'],
        "8" => $_POST['fiyat'],
        "14" => $_POST['resim'],
        "12_first" => $_POST['ad'],
        "12_last" => "",
        "13" => $_POST['email']
    );

    $result = $jotformAPI->createFormSubmission("222202437411037", $submission);
    print_r($result);
}


?>
<?php 

if(isset($_POST['addStock'])){
    $forms = $jotformAPI->getFormSubmissions("222202437411037");
    $submission = array(
        "5" => $_POST['urunAdi'],
        "6" => $_POST['barcode'],
        "7" => $_POST['stok'],
        "8" => $_POST['fiyat'],
        "12_first" => $_POST['ad'],
        "12_last" => "",
        "13" => $_POST['email']
    );

    $result = $jotformAPI->createFormSubmission("222202437411037", $submission);
    print_r($result);
}

?>
<?php 
require_once("ApiConfig.php");
$userDetails = array(
    "username" => "mithat_ck2",
    "password" => "123456789"
);

// $response = $jotformAPI->loginUser($creadentials);
$response = $jotformAPI->loginUser($userDetails);

print_r($response);
$form = array(
    'questions' => array(
        array(
            'type' => 'control_head',
            'text' => 'Form Title',
            'order' => '1',
            'name' => 'Header',
        ),
        array(
            'type' => 'control_textbox',
            'text' => 'Text Box Title',
            'order' => '2',
            'name' => 'TextBox',
            'validation' => 'None',
            'required' => 'No',
            'readonly' => 'No',
            'size' => '20',
            'labelAlign' => 'Auto',
            'hint' => '',
        ),
    ),
    'properties' => array(
        'title' => 'New Form',
        'height' => '600',
    ),
    'emails' => array(
        array(
            'type' => 'notification',
            'name' => 'notification',
            'from' => 'default',
            'to' => 'noreply@jotform.com',
            'subject' => 'New Submission',
            'html' => 'false'
        ),
    ),
);

$response = $jotformAPI->createForm($form);
print_r($response);

?>
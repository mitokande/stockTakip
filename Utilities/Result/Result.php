<?php
namespace Utilities\Result;

require_once("Utilities/Result/DataResult.php");

class Result
{
    public string $message;
    public bool $success;
    public function __construct($message, $success)
    {
        $this->message = $message;
        $this->success = $success;
    }

}
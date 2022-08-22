<?php
namespace Utilities\Result;

require_once("Utilities/Result/Result.php");

class DataResult extends Result
{
  public $data;

  public function __construct($data,$message, $success)
  {
      $this->data = $data;
      parent::__construct($message, $success);
  }

}
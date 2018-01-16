<?php

namespace Exceptions;

class Exception extends \Exception{
  protected $message;
  protected $description;
  protected $code;


  public function __construct($message, $description, $code){
    $this->message      = $message;
    $this->description  = $description;
    $this->code         = $code;
  }

  public function getDescription(){
    return $this->description;
  }
}

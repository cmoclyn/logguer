<?php

namespace Exceptions;

class Exception extends \Exception{
  protected $message;
  protected $description;
  protected $code;


  public function __construct(string $message, string $description, string $code){
    $this->message      = $message;
    $this->description  = $description;
    $this->code         = $code;
  }

  public function getDescription():string{
    return $this->description;
  }
}

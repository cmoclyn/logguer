<?php

namespace Tests;

class Exception extends \Exceptions\Exception{
  const LOG_FILE = "Test_Exceptions";

  const ERROR   = 0;
  const WARNING = 1;
  const INFO    = 2;
  const DEBUG   = 3;
  const NOTHING = 4;

  public function __construct($message, $value){
    switch($value){
      case self::ERROR:
        $title  = "Error exception";
        $type   = "E";
        break;
      case self::WARNING:
        $title  = "Warning exception";
        $type   = "W";
        break;
      case self::INFO:
        $title  = "Info exception";
        $type   = "I";
        break;
      case self::DEBUG:
        $title  = "Debug exception";
        $type   = "D";
        break;
      case self::NOTHING:
        $title  = "Nothing";
        $type   = "N";
        break;
    }

    parent::__construct($title, $message, $type);
  }
}

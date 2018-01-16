<?php

namespace Exceptions;

class ExceptionWriter extends Exception{
  const DIRECTORY_NOT_EXISTING  = 0;
  const CAN_NOT_OPEN_FILE       = 1;
  const CAN_NOT_WRITE           = 2;
  const CAN_NOT_CLOSE           = 3;

  public function __construct($message, $value){
    switch($value){
      case self::DIRECTORY_NOT_EXISTING:
        $title  = "Directory doesn`t exists";
        $type   = "E";
        break;
      case self::CAN_NOT_OPEN_FILE:
        $title  = "Can`t open file";
        $type   = "E";
        break;
      case self::CAN_NOT_WRITE:
        $title  = "Can`t write in the file";
        $type   = "E";
        break;
      case self::CAN_NOT_CLOSE:
        $title  = "Can`t close the file";
        $type   = "E";
        break;
    }

    parent::__construct($title, $message, $type);
  }
}

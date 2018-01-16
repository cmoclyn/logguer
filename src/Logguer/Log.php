<?php

namespace Logguer;

class Log{
  const REGEX_LOG_FORMAT  = "{date}\t{type}/{class} [{message}]: {description} ('{file}': {line})\n";

  /**
   * @var \DateTime
   */
  private $date;
  /**
   * @var string
   */
  private $class = null;
  /**
   * @var string
   */
  private $message = null;
  /**
   * @var string
   */
  private $description = null;
  /**
   * @var string
   */
  private $file = null;
  /**
   * @var int
   */
  private $line = null;
  /**
   * @var string
   */
  private $type = 'I';



  public function __construct(){
    $time = microtime(true);
    $micro = sprintf("%06d", ($time - floor($time)) * 1000000);
    $date = new \DateTime(date('Y-m-d H:i:s.'.$micro, $time));
    $date->setTimeZone(new \DateTimeZone('Europe/Paris'));
    $this->date = $date;
  }

  public function __toString(){
    $str = self::REGEX_LOG_FORMAT;

    $str = str_replace('{date}', $this->date->format('d/m/Y H:i:s.u'), $str);
    $str = str_replace('{type}', $this->type, $str);
    $str = str_replace('{class}', $this->class, $str);
    $str = str_replace('{message}', $this->message, $str);
    $str = str_replace('{description}', (!is_null($this->description) ? $this->description : ''), $str);
    // if(!is_null($this->description)){
    //   $str = str_replace('{description}', $this->description, $str);
    // }else{
    //   $str = str_replace('{description} ', '', $str);
    // }
    $str = str_replace('{file}', $this->file, $str);
    $str = str_replace('{line}', $this->line, $str);

    if(is_null($this->file) && is_null($this->line)){
      $str = substr($str, 0, -9)."\n";
    }

    return $str;
  }

  #######################
  ## Getters & Setters ##
  #######################


  /**
   * Get the value of Class
   *
   * @return string
   */
  public function getClass(){
    return $this->class;
  }

  /**
   * Set the value of Class
   *
   * @param string class
   */
  public function setClass($class){
    $this->class = $class;
  }

  /**
   * Get the value of Message
   *
   * @return string
   */
  public function getMessage(){
    return $this->message;
  }

  /**
   * Set the value of Message
   *
   * @param string message
   */
  public function setMessage($message){
    $this->message = $message;
  }

  /**
   * Get the value of Description
   *
   * @return string
   */
  public function getDescription(){
    return $this->description;
  }

  /**
   * Set the value of Description
   *
   * @param string description
   */
  public function setDescription($description){
    $this->description = $description;
  }

  /**
   * Get the value of File
   *
   * @return string
   */
  public function getFile(){
    return $this->file;
  }

  /**
   * Set the value of File
   *
   * @param string file
   */
  public function setFile($file){
    $this->file = $file;
  }

  /**
   * Get the value of Line
   *
   * @return int
   */
  public function getLine(){
    return $this->line;
  }

  /**
   * Set the value of Line
   *
   * @param int line
   */
  public function setLine($line){
    $this->line = $line;
  }

  /**
   * Get the value of Type
   *
   * @return string
   */
  public function getType(){
    return $this->type;
  }

  /**
   * Set the value of Type
   *
   * @param string type
   */
  public function setType($type){
    if(is_numeric($type)){
      $type = 'I';
    }
    $this->type = $type;
  }

}

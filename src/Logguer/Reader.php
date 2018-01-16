<?php

namespace Logguer;

use Exceptions\ExceptionReader;

/**
 * @codeCoverageIgnore
 */
class Reader{
  /**
   * @var string
   */
  private $directory;


  /**
   * Get the value of Directory
   *
   * @return string
   */
  public function getDirectory(){
    return $this->directory;
  }

  /**
   * Set the value of Directory
   *
   * @param string directory
   */
  public function setDirectory(string $directory){
    if(!is_dir($directory)){
      throw new ExceptionReader("The directory '$directory' doesn`t exists", ExceptionReader::DIRECTORY_NOT_EXISTING);
    }
    $this->directory = $directory;
  }

  public function getLogFiles():array{
    return glob("{$this->directory}/*.log");
  }

  public function readFile(string $file):array{
    if(($lines = file($file)) === false){
      throw new ExceptionReader("Can`t open or read the file '$file'", ExceptionReader::CAN_NOT_OPEN_FILE);
    }
    return $lines;
  }

  public function searchInFile(string $file, ?array $types = null, ?\DateTime $beginDate = null, ?\DateTime $endDate = null, ?string $pattern = null):array{
    if(($lines = file($file)) === false){
      throw new ExceptionReader("Can`t open or read the file '$file'", ExceptionReader::CAN_NOT_OPEN_FILE);
    }

    is_null($types)     ? $types      = array('V', 'I', 'D', 'W', 'E') : null;
    is_null($pattern)   ? $pattern    = '/.*/' : null;
    if(is_null($beginDate)){
      $beginDate = new \DateTime();
      $beginDate->setTimezone(new \DateTimeZone('Europe/Paris'));
    }
    if(is_null($endDate)){
      $endDate   = new \DateTime();
      $endDate->setTimezone(new \DateTimeZone('Europe/Paris'));
    }

    $res = array();
    foreach($lines as $line){
      $day          = substr($line, 0, 2);
      $month        = substr($line, 3, 2);
      $year         = substr($line, 6, 4);
      $hour         = substr($line, 11, 2);
      $minute       = substr($line, 14, 2);
      $second       = substr($line, 17, 2);
      $microseconds = substr($line, 20, 6);
      $date = new \DateTime();
      $date->setTimeZone(new \DateTimeZone('Europe/Paris'));
      $date->setDate($year, $month, $day);
      $date->setTime($hour, $minute , $second , $microseconds);

      if($date >= $beginDate && $date <= $endDate){
        foreach($types as $type){
          //dd/mm/YYYY hh::ii:ss.uuuuuu
          if(preg_match("/\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}:\d{2}\.\d{6}\s$type/", $line)){
            $res[] = $line;
          }
        }
      }
    }
    return $res;
  }
}

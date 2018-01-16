<?php

namespace Logguer;

use Exceptions\ExceptionWriter;

class Writer{
  /**
   * @var string
   */
  private $directory;
  /**
   * @var string
   */
  private $file;

  /**
   * @codeCoverageIgnore
   */
  public function log(Log $log){
    if(($file = @fopen("{$this->directory}/{$this->file}", 'a')) === false){
      throw new ExceptionWriter("Can`t open or create the file '{$this->directory}/{$this->file}'", ExceptionWriter::CAN_NOT_OPEN_FILE);
    }
    if(fwrite($file, $log) === false){
      $permissions = substr(sprintf('%o', fileperms($this->directory/$this->file)), -4);
      throw new ExceptionWriter("Can`t write in the file '{$this->directory}/{$this->file}', check the permissions : '$permissions'", ExceptionWriter::CAN_NOT_WRITE);
    }
    if(fclose($file) === false){
      throw new ExceptionWriter("Can`t close the file '{$this->directory}/{$this->file}'", ExceptionWriter::CAN_NOT_CLOSE);
    }
  }

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
  public function setDirectory($directory){
    if(!is_dir($directory)){
      @mkdir($directory, 0777, true);
    }
    if(!is_dir($directory)){
      throw new ExceptionWriter("The directory '$directory' doesn`t exists, and can`t be created", ExceptionWriter::DIRECTORY_NOT_EXISTING);
    }
    $this->directory = $directory;
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
    $date = date('Y_m_d');
    $file .= "_$date.log";
    $this->file = $file;
  }

}

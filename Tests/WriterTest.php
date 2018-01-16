<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use Logguer\Writer;
use Logguer\Log;
use Exceptions\ExceptionWriter;

class WriterTest extends TestCase{

  /**
   * @covers Logguer\Writer::setDirectory
   * @covers Logguer\Writer::getDirectory
   */
  public function testSetDirectoryOk(){
    $directory = __DIR__.'/logs/';
    $writer = new Writer();
    $writer->setDirectory($directory);
    $this->assertEquals($directory, $writer->getDirectory());
  }


  /**
   * @covers Logguer\Writer::setDirectory
   */
  public function testSetDirectoryFail(){
    $directory = __FILE__;
    $writer = new Writer();
    try{
      $writer->setDirectory($directory);
    }catch(ExceptionWriter $e){
      $this->assertInstanceOf(ExceptionWriter::class, $e);
    }
  }


  /**
   * @covers Logguer\Writer::setFile
   * @covers Logguer\Writer::getFile
   */
  public function testSetFileOk(){
    $file = 'test';
    $writer = new Writer();
    $writer->setFile($file);
    $this->assertEquals($file.'_'.date('Y_m_d').'.log', $writer->getFile());
  }

  /**
   * @covers Logguer\Log::__construct
   * @covers Logguer\Log::getClass
   * @covers Logguer\Log::setClass
   * @covers Logguer\Log::getMessage
   * @covers Logguer\Log::setMessage
   * @covers Logguer\Log::getDescription
   * @covers Logguer\Log::setDescription
   * @covers Logguer\Log::getFile
   * @covers Logguer\Log::setFile
   * @covers Logguer\Log::getLine
   * @covers Logguer\Log::setLine
   * @covers Logguer\Log::getType
   * @covers Logguer\Log::setType
   * @covers Logguer\Log::__toString
   * @covers Logguer\Writer::setDirectory
   * @covers Logguer\Writer::setFile
   * @covers Logguer\Writer::log
   */
  public function testLogOk(){
    $log = new Log();
    $log->setClass('CustomClass');
    $this->assertEquals('CustomClass', $log->getClass());
    $log->setMessage('Custom Message');
    $this->assertEquals('Custom Message', $log->getMessage());
    $log->setDescription('Custom Description');
    $this->assertEquals('Custom Description', $log->getDescription());
    $log->setFile('CustomFile');
    $this->assertEquals('CustomFile', $log->getFile());
    $log->setLine(42);
    $this->assertEquals(42, $log->getLine());
    $log->setType('D');
    $this->assertEquals('D', $log->getType());
    $log->setType(0);
    $this->assertEquals('I', $log->getType());

    $writer = new Writer();
    $writer->setDirectory(__DIR__.'/logs/');
    $writer->setFile('test_log');
    $writer->log($log);

    $log2 = new Log();
    $writer->log($log2);
  }
}

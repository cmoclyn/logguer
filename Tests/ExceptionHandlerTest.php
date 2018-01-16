<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use Exceptions\ExceptionHandler;
use Logguer\Writer;

class ExceptionHandlerTest extends TestCase{

  // public function setUp(){
  //   $writer = new Writer();
  //   $writer->setDirectory(__DIR__.'/logs/');
  //   $writer->setFile('test');
  //   ExceptionHandler::setWriter($writer);
  // }

  /**
   * @dataProvider providerForSetLangOk
   * @covers Exceptions\ExceptionHandler::setLang
   */
  public function testSetLangOk($lang){
    ExceptionHandler::setLang($lang);
    $this->assertTrue(true);
  }

  /**
   * @dataProvider providerForSetLangFail
   * @covers Exceptions\ExceptionHandler::setLang
   */
  public function testSetLangFail($lang){
    try{
      ExceptionHandler::setLang($lang);
    }catch(\Exception $e){
      $this->assertInstanceOf(\Exception::class, $e);
    }
  }

  /**
   * @dataProvider providerForSetTemplateOk
   * @covers Exceptions\ExceptionHandler::setTemplate
   */
  public function testSetTemplateOk($file){
    ExceptionHandler::setTemplate($file);
    $this->assertTrue(true);
  }

  /**
   * @dataProvider providerForSetTemplateFail
   * @covers Exceptions\ExceptionHandler::setTemplate
   * @covers Exceptions\ExceptionHandler::getLang
   */
  public function testSetTemplateFail($file){
    try{
      ExceptionHandler::setTemplate($file);
    }catch(\Exception $e){
      $this->assertInstanceOf(\Exception::class, $e);
    }
  }

  /**
   * @covers Exceptions\ExceptionHandler::debugEnable
   */
  public function testSetDebugEnable(){
    ExceptionHandler::debugEnable();
    $this->assertTrue(true);
  }

  /**
   * @depends testSetDebugEnable
   * @dataProvider providerForThrowException
   * @covers Exceptions\ExceptionHandler::__construct
   * @covers Exceptions\ExceptionHandler::setWriter
   * @covers Exceptions\ExceptionHandler::displayHTML
   * @covers Exceptions\ExceptionHandler::formatArgs
   * @covers Exceptions\Exception::__construct
   * @covers Exceptions\Exception::getDescription
   */
  public function testThrowException($exceptionMessage, $exceptionType){

    $reflection = new \ReflectionClass('Exceptions\ExceptionHandler');
    $instance = $reflection->newInstanceWithoutConstructor();
    set_exception_handler(array($instance, '__construct'));
    try{
      throw new Exception($exceptionMessage, $exceptionType);
    }catch(\Exception $e){
      $writer = new Writer();
      $writer->setDirectory(__DIR__.'/logs/');
      $writer->setFile('test');
      ExceptionHandler::setWriter($writer);
      $handler = new ExceptionHandler($e, true);
      ob_clean();
      $this->assertInstanceOf(\Exception::class, $e);
    }
  }




  public function providerForSetLangOk(){
    return array(
      array('Fr'),
      array('en')
    );
  }

  public function providerForSetLangFail(){
    return array(
      array('aa'),
      array('zz')
    );
  }

  public function providerForSetTemplateOk(){
    return array(
      array(dirname(__DIR__).'/src/Exceptions/templates/exception.php')
    );
  }

  public function providerForSetTemplateFail(){
    return array(
      array('templateNotExisting')
    );
  }

  public function providerForThrowException(){
    return array(
      array('ERROR', Exception::ERROR),
      array('WARNING', Exception::WARNING),
      array('INFO', Exception::INFO),
      array('DEBUG', Exception::DEBUG),
      array('NOTHING', Exception::NOTHING),
    );
  }
}

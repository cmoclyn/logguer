<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use Logguer\Dump;

class DumpTest extends TestCase{

  /**
   * @covers Logguer\Dump::__construct
   * @covers Logguer\Dump::dump
   * @covers Logguer\Dump::__toString
   */
  public function testBoolean(){
    $bool = true;
    $dump = new Dump($bool);
    $res = $dump->__toString();
    $this->assertEquals($this->highlight("true\n"), $res);
  }

  /**
   * @covers Logguer\Dump::__construct
   * @covers Logguer\Dump::dump
   * @covers Logguer\Dump::__toString
   */
  public function testInteger(){
    $int = 42;
    $dump = new Dump($int);
    $res = $dump->__toString();
    $this->assertEquals($this->highlight("42\n"), $res);
  }

  /**
   * @covers Logguer\Dump::__construct
   * @covers Logguer\Dump::dump
   * @covers Logguer\Dump::__toString
   */
  public function testDouble(){
    $float = 42.;
    $dump = new Dump($float);
    $res = $dump->__toString();
    $this->assertEquals($this->highlight(42.."\n"), $res);
  }

  /**
   * @covers Logguer\Dump::__construct
   * @covers Logguer\Dump::dump
   * @covers Logguer\Dump::__toString
   */
  public function testString(){
    $string = 'Hello World';
    $dump = new Dump($string);
    $res = $dump->__toString();
    $this->assertEquals($this->highlight("'Hello World'\n"), $res);
  }

  /**
   * @covers Logguer\Dump::__construct
   * @covers Logguer\Dump::dump
   * @covers Logguer\Dump::__toString
   */
  public function testRessource(){
    $resource = fopen(__FILE__, 'a');
    $dump = new Dump($resource);
    $res = $dump->__toString();
    $this->assertEquals($this->highlight("{resource}\n"), $res);
  }

  /**
   * @covers Logguer\Dump::__construct
   * @covers Logguer\Dump::dump
   * @covers Logguer\Dump::__toString
   */
  public function testNull(){
    $null = null;
    $dump = new Dump($null);
    $res = $dump->__toString();
    $this->assertEquals($this->highlight("null\n"), $res);
  }

  /**
   * @covers Logguer\Dump::__construct
   * @covers Logguer\Dump::dump
   * @covers Logguer\Dump::__toString
   */
  public function testArray(){
    $array = array('Hello' => 'world', 42 => 'universe');
    $dump = new Dump($array, 0, false);
    $res = $dump->__toString();
    $this->assertEquals("array(\n  [Hello] => 'world'\n  [42] => 'universe'\n)\n", $res);
  }

  public function highlight($str){
    $out = highlight_string("<?php\n{$str}", true);
		return preg_replace('/&lt;\\?php<br \\/>/', '', $out, 1);
  }

}

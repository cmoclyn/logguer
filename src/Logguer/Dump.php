<?php

namespace Logguer;

class Dump{

  private $depth;
  private $objects = array();
  private $output;

  public function __construct($var, $depth = 10, $highlight = true){
    $this->depth = $depth;
    $this->output = $this->dump($var, 0)."\n";

		if($highlight){
			$this->output = highlight_string("<?php\n{$this->output}", true);
			$this->output = preg_replace('/&lt;\\?php<br \\/>/', '', $this->output, 1);
		}
  }

  private function dump($var, $level = 0){
    switch(gettype($var)){
      case 'boolean':
        return $var ? "true" : "false";
        break;

      case 'integer':
      case 'double':
        return "$var";
        break;

      case 'string':
        return "'$var'";
        break;

      case 'resource':
        return "{resource}";
        break;

      case 'NULL':
        return "null";
        break;

      case 'unknow type':
        return "{unknow}";
        break;

      case 'array':
        if($level > $this->depth){
          return "array(...)";
        }elseif(empty($var)){
          return "array()";
        }
        $keys = array_keys($var);
        $spaces = str_repeat(' ', $level*4);
        $output = "array(";
        foreach($keys as $key){
          $output .= "\n $spaces [$key] => ".$this->dump($var[$key], $level+1);
        }
        $output .= "\n$spaces)";
        return $output;
        break;

      case 'object':
        $id = array_push($this->objects, $var);
        if($level > $this->depth){
          return get_class($var)."#$id{...}";
        }
        $className = get_class($var);
        $members = (array)$var;
        $keys = array_keys($members);
        $spaces = str_repeat(' ', $level*4);
        $output = "$className#$id{";
        foreach($keys as $key){
          $keyDisplay = strtr(trim($key), array("\0" => ':')); // Replace \0 by : in $key
          $output .= "\n $spaces [$keyDisplay] => ";
          $output .= $this->dump($members[$key], $level+1);
        }
        $output .= "\n$spaces)";
        return $output;
        break;
    }
  }

  public function __toString(){
    return $this->output;
  }
}

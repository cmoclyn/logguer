<?php

namespace Exceptions;

class ExceptionHandler{

  ##############
  ## Template ##
  ##############

  /**
   * Template use to display the exceptions
   * @var string
   */
  private static $template = __DIR__.'/templates/exception.php';

  /**
   * Define the template for the exception
   * @param string $file Path to the template to use
   */
  public static function setTemplate($file){
    if(!file_exists($file)){
      $langUse = self::getLang();
      throw new \Exception(str_replace('{%file}', self::$lang, $langUse::FILE_NOT_EXISTS));
    }
    self::$template = $file;
  }


  ##########
  ## Lang ##
  ##########

  private static $langsAvailable = array(
    'en' => 'Exceptions\Langs\En',
    'fr' => 'Exceptions\Langs\Fr',
  );

  private static $lang = 'fr';

  /**
   * Define the lang to use
   * @param string $lang Lang to use
   */
  public static function setLang($lang){
    $lang = strtolower($lang);
    if(!array_key_exists($lang, self::$langsAvailable)){
      $langUse = self::getLang();
      throw new \Exception(str_replace('{%lang}', $lang, $langUse::NO_LANG_DATA));
    }
    self::$lang = $lang;
  }

  /**
   * Get the lang
   * @return string
   */
  private static function getLang(){
    return self::$langsAvailable[self::$lang];
  }


  ############
  ## Writer ##
  ############

  /**
   * Exception writer
   * @var \Logguer\Writer
   */
  private static $writer = null;

  /**
   * Set the value of Exception writer
   *
   * @param \Logguer\Writer writer
   */
  public static function setWriter($writer){
    self::$writer = $writer;
  }


  ###########
  ## Debug ##
  ###########

  /**
   * Debug mode
   * @var boolean
   */
  private static $debug = false;

  /**
   * Enable the debug mode
   */
  public static function debugEnable(){
    self::$debug = true;
  }


  public function __construct($exception, $caught = false){
    if(self::$debug){ // If we are in a debug mode
      $this->displayHTML($exception, $caught); // We can display the exception
    }

    if(!is_null(self::$writer)){ // If there is a writer
      $class = get_class($exception);

      $log = new \Logguer\Log();
      $log->setClass($class);
      $log->setMessage($exception->getMessage());
      method_exists($exception, 'getDescription') ? $log->setDescription($exception->getDescription()) : null;
      $log->setFile($exception->getFile());
      $log->setLine($exception->getLine());
      $log->setType($exception->getCode());

      if(defined("{$class}::LOG_FILE")){
        self::$writer->setFile($class::LOG_FILE);
      }
      self::$writer->log($log);
    }
  }


  #############
  ## Display ##
  #############

  public function displayHTML($exception, $caught){
    $langUse = self::getLang();
    $textCaughtException = $caught ? $langUse::CAUGHT_EXCEPTION : $langUse::UNCAUGHT_EXCEPTION;
    $textFileAndLine = str_replace('{%file}',
                                    $exception->getFile(),
                                    str_replace('{%line}',
                                                $exception->getLine(),
                                                $langUse::FILE_AND_LINE
                                    )
                        );
    $typeException = 'danger';
    if(method_exists($exception, 'getCode')){
      switch($exception->getCode()){
        case 'E':
          $typeException = 'danger';
          break;

        case 'W':
          $typeException = 'warning';
          break;

        case 'I':
          $typeException = 'primary';
          break;

        case 'D':
          $typeException = 'secondary';
          break;

        default:
          $typeException = 'danger';
          break;
      }
    }
    $handler = $this;
    ob_clean();
    include self::$template;
  }

  private function formatArgs($args){
    $result = array();
    foreach($args as $key => $item){
      switch(gettype($item)){
        case 'object':
          $formattedValue = sprintf('<em>object</em>(%s)', get_class($item));
          break;

        case 'array':
          $formattedValue = sprintf('<em>array</em>(%s)', $this->formatArgs($item));
          break;

        case 'null':
          $formattedValue = '<em>null</em>';
          break;

        case 'boolean':
          $val = $item ? "true" : "false";
          $formattedValue = '<em>'.$val.'</em>';
          break;

        case 'resource':
          $formattedValue = '<em>resource</em>';
          break;

        case 'string':
          $formattedValue = "<em>'$item'</em>";
          break;

        default:
          $formattedValue = $item;
          break;
      }

      $result[] = is_int($key) ? $formattedValue : sprintf("'%s' => %s", htmlspecialchars($key), $formattedValue);
    }

    return implode(', ', $result);
  }

}

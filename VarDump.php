<?php

/**
 * Author: Dragu Costel
 * Email : dragu.costel@yahoo.com
 * Date: 16.06.2017
 * Time: 20:09
 * File name: VarDump.php
 */
class VarDump {

  private $tab = 2;
  private $tabCharacter = ' ';
  private static $objectCount = 1;

  /**
   * Create object callable
   * @param $data - The data to dump
   * @return string
   */
  public function __invoke($data) {
    if (is_array($data)) {
      return $this->output = $this->valueArray($data, 0);
    }
    if (is_object($data)) {
      return $this->output = $this->valueArray($data, 0);
    }
  }

  /**
   * Process array value;
   * @param $data
   * @param $leaf
   * @return string
   */
  private function valueArray($data, $leaf) {
    $output = $this->addTab($leaf);
    $output .= 'array(' . count($data) . ') {' . PHP_EOL;
    ++$leaf;
    foreach ($data as $key => $value) {
      $valueType = gettype($value);
      $keyType = gettype($key);
      $keyFunction = 'key' . ucfirst($keyType);
      if (method_exists($this, $keyFunction)) {
        $output .= $this->$keyFunction($key, $leaf);
      }
      $valueFunction = 'value' . ucfirst(gettype($value));
      if (method_exists($this, $valueFunction)) {
        $output .= $this->$valueFunction($value, $leaf, $valueType);
      }
    }
    $output .= $this->addTab(--$leaf) . '}' . PHP_EOL;
    return $output;
  }

  /**
   * Process object value
   * @param $obj - The object
   * @param $leaf - The leaf of the tree
   * @param $type - The object type
   * @return string - result
   */
  private function valueObject($obj, $leaf, $type) {
    $output = $this->addTab($leaf);
    ++$leaf;
    $objVars = get_object_vars($obj);
    $output .= $type . '(' . get_class($obj) . ')' . '#' . self::$objectCount . '(' . count($objVars) . ')' . PHP_EOL;
    $output .= $this->valueArray($objVars, $leaf);
    ++self::$objectCount;
    return $output;
  }

  /**
   * Create string value
   * @param $key -  The value of the key
   * @param $leaf - The leaf of the tree
   * @return string - result
   */
  private function keyString($key, $leaf) {
    $output = $this->addTab($leaf);
    $output .= '["' . $key . '"]=>' . PHP_EOL;
    return $output;
  }

  /**
   * Create key integer
   * @param $key -  The value of the key
   * @param $leaf - The leaf of the tree
   * @return string - result
   */
  private function keyInteger($key, $leaf) {
    $output = $this->addTab($leaf);
    $output .= '[' . $key . ']=>' . PHP_EOL;
    return $output;
  }

  /**
   * Process the string value
   * @param $value - The string value
   * @param $leaf - The leaf of the tree
   * @return string - result
   */
  private function valueString($value, $leaf) {
    $output = $this->addTab($leaf);
    $output .= 'string (' . strlen($value) . ') "' . $value . '"' . PHP_EOL;
    return $output;
  }

  /**
   * Process the double value
   * @param $double - The double number
   * @param $leaf - The leaf of the tree
   * @return string - result
   */
  private function valueDouble($double, $leaf) {
    return $this->valueNumber($double, $leaf, 'double');
  }


  /**
   * Process integer value
   * @param $int - The number
   * @param $leaf - The leaf of the tree
   * @return string - result
   */
  private function valueInteger($int, $leaf) {
    return $this->valueNumber($int, $leaf, 'int');
  }

  /**
   * Process value number
   * @param $number - The number value
   * @param $leaf - The leaf of the tree
   * @param string $type - The number type
   * @return string - result
   */
  private function valueNumber($number, $leaf, $type = 'int') {
    $output = $this->addTab($leaf);
    $output .= $type . '(' . $number . ')' . PHP_EOL;
    return $output;
  }

  /**
   * Process the boolean value
   * @param $bool - The bool value
   * @param $leaf - The leaf of the tree
   * @return string - result
   */
  private function valueBoolean($bool, $leaf) {
    $output = $this->addTab($leaf);
    $output .= 'bool(' . ($bool ? 'true' : 'false') . ')' . PHP_EOL;
    return $output;
  }

  /**
   * Process null value
   * @param $null - The null value
   * @param $leaf - The leaf of the tree
   * @return string - result
   */
  private function valueNULL($null, $leaf) {
    $output = $this->addTab($leaf);
    $output .= 'NULL' . PHP_EOL;
    return $output;
  }

  /**
   * Add tab spaces
   * @param $leaf - The leaf of the tree
   * @return string - result
   */
  private function addTab($leaf) {
    return str_repeat($this->tabCharacter, $leaf * $this->tab);
  }

}
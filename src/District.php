<?php
namespace Bricks\Business\Location\IpGeoBase;

/**
 * Федеральный округ.
 *
 * @author Artur Sh. Mamedbekov
 */
class District{
  /**
   * @var string Наименование.
   */
  private $name;

  /**
   * @param string $name Наименование.
   */
  public function __construct($name){
    $this->name = $name;
  }

  /**
   * @return string Наименование.
   */
  public function getName(){
    return $this->name;
  }
}

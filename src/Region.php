<?php
namespace Bricks\Business\Location\IpGeoBase;

/**
 * Регион.
 *
 * @author Artur Sh. Mamedbekov
 */
class Region{
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

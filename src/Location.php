<?php
namespace Bricks\Business\Location\IpGeoBase;

/**
 * Географическое местоположение.
 *
 * @author Artur Sh. Mamedbekov
 */
class Location{
  /**
   * @var float Широта.
   */
  private $lat;

  /**
   * @var float Долгота.
   */
  private $lng;

  /**
   * @param float $lat Широта.
   * @param float $lng Долгота.
   */
  public function __construct($lat, $lng){
    $this->lat = $lat;
    $this->lng = $lng;
  }

  /**
   * @return float Широта.
   */
  public function getLat(){
    return $this->lat;
  }

  /**
   * @return float Долгота.
   */
  public function getLng(){
    return $this->lng;
  }
}

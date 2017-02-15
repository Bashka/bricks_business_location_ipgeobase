<?php
namespace Bricks\Business\Location\IpGeoBase;

/**
 * Информация о конкретном IP-адресе.
 *
 * @author Artur Sh. Mamedbekov
 */
class IpInfo{
  /**
   * @var string IP-адрес.
   */
  private $ip;

  /**
   * @var District Федеральный округ.
   */
  private $district;

  /**
   * @var Region Регион.
   */
  private $region;

  /**
   * @var City Город.
   */
  private $city;

  /**
   * @var Location Расположение.
   */
  private $location;

  /**
   * @var string Дополнительное сообщение.
   */
  private $message;

  /**
   * @param string $ip IP-адрес.
   * @param District $district Федеральный округ.
   * @param Region $region Регион.
   * @param City $city Город.
   * @param Location $location Расположение.
   */
  public function __construct(
    $ip,
    District $district, 
    Region $region, 
    City $city, 
    Location $location,
    $message = ''
  ){
    $this->ip = $ip;
    $this->district = $district;
    $this->region = $region;
    $this->city = $city;
    $this->location = $location;
    $this->message = $message;
  }

  /**
   * @return string IP-адрес.
   */
  public function getIp(){
    return $this->ip;
  }

  /**
   * @return District Федеральный округ.
   */
  public function getDistrict(){
    return $this->district;
  }

  /**
   * @return Region Регион.
   */
  public function getRegion(){
    return $this->region;
  }

  /**
   * @return City Город.
   */
  public function getCity(){
    return $this->city;
  }

  /**
   * @return Location Расположение.
   */
  public function getLocation(){
    return $this->location;
  }

  /**
   * @return string Дополнительное сообщение.
   */
  public function getMessage(){
    return $this->message;
  }
}

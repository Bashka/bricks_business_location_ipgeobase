<?php
namespace Bricks\Business\Location\IpGeoBase\UnitTest;

use PHPUnit_Framework_TestCase;
use Bricks\Business\Location\IpGeoBase\Response;
use Bricks\Business\Location\IpGeoBase\IpInfo;
use Bricks\Business\Location\IpGeoBase\District;
use Bricks\Business\Location\IpGeoBase\Region;
use Bricks\Business\Location\IpGeoBase\City;
use Bricks\Business\Location\IpGeoBase\Location;

/**
 * @author Artur Sh. Mamedbekov
 */
class ResponseTest extends PHPUnit_Framework_TestCase{
  public function testGetIpInfo_shouldReturnNullIfInfoNotFound(){
    $response = new Response;
    
    $this->assertNull($response->getIpInfo('1.1.1.1'));
  }

  public function testSetIpInfo_shouldReset(){
    $response = new Response;
    $response->setIpInfo(new IpInfo('1.1.1.1', new District('Центральный'), new Region('Москва'), new City('Москва'), new Location(0.0, 0.0)));
    $response->setIpInfo(new IpInfo('1.1.1.1', new District('Центральный'), new Region('Санкт-Петербург'), new City('Санкт-Петербург'), new Location(0.0, 0.0)));

    $this->assertEquals('Санкт-Петербург', $response->getIpInfo('1.1.1.1')->getCity()->getName());
  }
}

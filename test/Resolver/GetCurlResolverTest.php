<?php
namespace Bricks\Business\Location\IpGeoBase\UnitTest\Resolver;

use PHPUnit_Framework_TestCase;
use DOMDocument;
use Bricks\Business\Location\IpGeoBase\Request;
use Bricks\Business\Location\IpGeoBase\Resolver\GetCurlResolver;

/**
 * @author Artur Sh. Mamedbekov
 */
class GetCurlResolverTest extends PHPUnit_Framework_TestCase{
  public function testXmlToResponse(){
    $xml = '<?xml version="1.0" encoding="Windows-1251"?>' . "\n" .
      '<ip-answer id="123">' .
      '<ip value="1.1.1.1"><district>Центральный</district><region>Москва</region><city>Москва</city><lat>55.755787</lat><lng>37.617634</lng></ip>' .
      '</ip-answer>';
    $dom = new DOMDocument('1.0', 'Windows-1251');
    $dom->loadXML(iconv('UTF-8', 'Windows-1251', $xml));

    $response = GetCurlResolver::xmlToResponse($dom);

    $this->assertEquals('123', $response->getId());

    $this->assertEquals('Центральный', $response->getIpInfo('1.1.1.1')->getDistrict()->getName());
    $this->assertEquals('Москва', $response->getIpInfo('1.1.1.1')->getRegion()->getName());
    $this->assertEquals('Москва', $response->getIpInfo('1.1.1.1')->getCity()->getName());
    $location = $response->getIpInfo('1.1.1.1')->getLocation();
    $this->assertEquals(55.755787, $location->getLat());
    $this->assertEquals(37.617634, $location->getLng());
    $this->assertEquals('', $response->getIpInfo('1.1.1.1')->getMessage());
  }
}

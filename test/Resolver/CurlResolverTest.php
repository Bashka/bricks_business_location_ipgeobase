<?php
namespace Bricks\Business\Location\IpGeoBase\UnitTest\Resolver;

use PHPUnit_Framework_TestCase;
use DOMDocument;
use Bricks\Business\Location\IpGeoBase\Request;
use Bricks\Business\Location\IpGeoBase\Resolver\CurlResolver;

/**
 * @author Artur Sh. Mamedbekov
 */
class CurlResolverTest extends PHPUnit_Framework_TestCase{
  public function testRequestToXml(){
    $request = new Request(123);
    $request->addTargetIp('1.1.1.1')
      ->addTargetIp('2.2.2.2');

    $xml = CurlResolver::requestToXml($request);

    $this->assertEquals(
      '<?xml version="1.0"?>' .
      "\n" .
      '<ipquery id="123"><fields><all/></fields><ip-list><ip>1.1.1.1</ip><ip>2.2.2.2</ip></ip-list></ipquery>' .
      "\n",
      $xml->saveXML()
    );
  }

  public function testXmlToResponse(){
    $xml = '<?xml version="1.0" encoding="Windows-1251"?>' . "\n" .
      '<ip-answer id="123">' .
      '<ip value="1.1.1.1"><district>Центральный</district><region>Москва</region><city>Москва</city><lat>55.755787</lat><lng>37.617634</lng></ip>' .
      '<ip value="2.2.2.2"><message>Not found</message></ip>' .
      '</ip-answer>';
    $dom = new DOMDocument('1.0', 'Windows-1251');
    $dom->loadXML(iconv('UTF-8', 'Windows-1251', $xml));

    $response = CurlResolver::xmlToResponse($dom);

    $this->assertEquals('123', $response->getId());

    $this->assertEquals('Центральный', $response->getIpInfo('1.1.1.1')->getDistrict()->getName());
    $this->assertEquals('Москва', $response->getIpInfo('1.1.1.1')->getRegion()->getName());
    $this->assertEquals('Москва', $response->getIpInfo('1.1.1.1')->getCity()->getName());
    $location = $response->getIpInfo('1.1.1.1')->getLocation();
    $this->assertEquals(55.755787, $location->getLat());
    $this->assertEquals(37.617634, $location->getLng());
    $this->assertEquals('', $response->getIpInfo('1.1.1.1')->getMessage());

    $this->assertEquals('Undefined', $response->getIpInfo('2.2.2.2')->getDistrict()->getName());
    $this->assertEquals('Undefined', $response->getIpInfo('2.2.2.2')->getRegion()->getName());
    $this->assertEquals('Undefined', $response->getIpInfo('2.2.2.2')->getCity()->getName());
    $location = $response->getIpInfo('2.2.2.2')->getLocation();
    $this->assertEquals(0, $location->getLat());
    $this->assertEquals(0, $location->getLng());
    $this->assertEquals('Not found', $response->getIpInfo('2.2.2.2')->getMessage());
  }
}

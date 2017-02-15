<?php
namespace Bricks\Business\Location\IpGeoBase\Resolver;

use RuntimeException;
use DOMDocument;
use Bricks\Business\Location\IpGeoBase\Request;
use Bricks\Business\Location\IpGeoBase\Response;
use Bricks\Business\Location\IpGeoBase\IpInfo;
use Bricks\Business\Location\IpGeoBase\District;
use Bricks\Business\Location\IpGeoBase\Region;
use Bricks\Business\Location\IpGeoBase\City;
use Bricks\Business\Location\IpGeoBase\Location;

/**
 * @author Artur Sh. Mamedbekov
 */
class CurlResolver implements ResolverInterface{
  /**
   * Метод формирует XML на основании запроса.
   *
   * @param Request $request Исходный запрос.
   *
   * @return DOMDocument Результирующий XML документ.
   */
  public static function requestToXml(Request $request){
    $xml = new DOMDocument;
    $xml->appendChild($xml->createElement('ipquery'));

    $xml->documentElement->setAttribute('id', $request->getId());

    $fields = $xml->createElement('fields');
    $fields->appendChild($xml->createElement('all'));
    $xml->documentElement->appendChild($fields);

    $ipList = $xml->createElement('ip-list');
    foreach($request as $targetIp){
      $ipList->appendChild($xml->createElement('ip', $targetIp));
    }
    $xml->documentElement->appendChild($ipList);

    return $xml;
  }

  /**
   * Метод формирует Response на основании XML.
   *
   * @param DOMDocument $xml Исходный XML документ.
   *
   * @return Response Результирующий ответ.
   */
  public static function xmlToResponse(DOMDocument $xml){
    $id = '';
    if($xml->documentElement->hasAttribute('id')){
      $id = $xml->documentElement->getAttribute('id');
    }

    $response = new Response($id);
    foreach($xml->documentElement->getElementsByTagName('ip') as $ipElement){
      $ip = $ipElement->getAttribute('value');

      $districtElement = $ipElement->getElementsByTagName('district');
      $district = $districtElement->length?
        new District($districtElement->item(0)->firstChild->data) :
        new District('Undefined');

      $regionElement = $ipElement->getElementsByTagName('region');
      $region = $regionElement->length?
        new Region($regionElement->item(0)->firstChild->data) :
        new Region('Undefined');

      $cityElement = $ipElement->getElementsByTagName('city');
      $city = $cityElement->length?
        new City($cityElement->item(0)->firstChild->data) :
        new City('Undefined');

      $latElement = $ipElement->getElementsByTagName('lat');
      $lat = $latElement->length?
        $latElement->item(0)->firstChild->data :
        0.0;
      $lngElement = $ipElement->getElementsByTagName('lng');
      $lng = $latElement->length?
        $lngElement->item(0)->firstChild->data :
        0.0;

      $messageElement = $ipElement->getElementsByTagName('message');
      $message = $messageElement->length?
        $messageElement->item(0)->firstChild->data :
        '';

      $response->setIpInfo(new IpInfo(
        $ip,
        $district,
        $region,
        $city,
        new Location((float) $lat, (float) $lng),
        $message
      ));
    }

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function resolve(Request $request){
    $requestXml = self::requestToXml($request);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://194.85.91.253:8090/geo/geo.html');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml->saveXML());

    $responseXml = curl_exec($ch);

    if($responseXml === false){
      $exception = new RuntimeException(curl_error($ch));
      curl_close($ch);
      throw $exception;
    }

    curl_close($ch);

    if($responseXml == 'Not found'){
      return new Response($request->getId());
    }

    $dom = new DOMDocument('1.0', 'Windows-1251');
    $dom->loadXML($responseXml);

    return self::xmlToResponse($dom);
  }
}

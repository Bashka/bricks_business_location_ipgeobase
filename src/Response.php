<?php
namespace Bricks\Business\Location\IpGeoBase;

use IteratorAggregate;
use ArrayIterator;

/**
 * Результат разрешения IP-адресов.
 *
 * @author Artur Sh. Mamedbekov
 */
class Response implements IteratorAggregate{
  /**
   * @var string Идентификатор запроса, на который был получен данный ответ.
   */
  private $id;

  /**
   * @var IpInfo[] Информация обо всех запрошенных IP-адресах.
   */
  private $ipInfo;

  /**
   * @param string $id Идентификатор запроса, на который был получен данный 
   * ответ.
   */
  public function __construct($id = ''){
    $this->id = $id;
    $this->ipInfo = [];
  }

  /**
   * Добавляет информацию об IP-адресе в ответ.
   *
   * @param IpInfo $ipInfo Информация об IP-адресе.
   */
  public function setIpInfo(IpInfo $ipInfo){
    $this->ipInfo[$ipInfo->getIp()] = $ipInfo;
  }

  /**
   * @return string Идентификатор запроса, на который был получен данный ответ.
   */
  public function getId(){
    return $this->id;
  }

  /**
   * @param string $ip Целевой IP-адрес.
   *
   * @return IpInfo|null Информация о целевом IP-адресе.
   */
  public function getIpInfo($ip){
    if(!isset($this->ipInfo[$ip])){
      return null;
    }

    return $this->ipInfo[$ip];
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator(){
    return new ArrayIterator($this->ipInfo);
  }
}

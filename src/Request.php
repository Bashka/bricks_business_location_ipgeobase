<?php
namespace Bricks\Business\Location\IpGeoBase;

use IteratorAggregate;
use ArrayIterator;

/**
 * Запрос на разрешение IP-адресов.
 *
 * @author Artur Sh. Mamedbekov
 */
class Request implements IteratorAggregate{
  /**
   * @var string Идентификатор запроса.
   */
  private $id;
  
  /**
   * @var string[] Целевые IP-адреса.
   */
  private $targetIps;

  /**
   * @param string $id Идентификатор запроса.
   */
  public function __construct($id = ''){
    $this->id = $id;
    $this->targetIps = [];
  }

  /**
   * Добавляет IP-адрес в запрос.
   *
   * @param string $ip Добавляемый IP-адрес.
   *
   * @return self
   */
  public function addTargetIp($ip){
    $this->targetIps[] = $ip;

    return $this;
  }

  /**
   * @return string Идентификатор запроса.
   */
  public function getId(){
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator(){
    return new ArrayIterator($this->targetIps);
  }
}

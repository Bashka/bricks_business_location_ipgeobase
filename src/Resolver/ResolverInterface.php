<?php
namespace Bricks\Business\Location\IpGeoBase\Resolver;

use RuntimeException;
use Bricks\Business\Location\IpGeoBase\Request;

/**
 * Механизм определение местоположения на основании IP-адреса.
 *
 * @author Artur Sh. Mamedbekov
 */
interface ResolverInterface{
  /**
   * @param Request $request Данные о разрешаемых IP-адреса.
   *
   * @throws RuntimeException Выбрасывается в случае возникновения ошибки во 
   * время запроса.
   *
   * @return Response Информация о разрешаемых IP-адреса.
   */
  public function resolve(Request $request);
}

# Выполнение запроса

Для разрешения IP-адреса используется метод _resolve_ классов, реализующих интерфейс _ResolverInterface_. Одним из таких классов является _CurlResolver_, использующий CURL в качестве транспортной инфраструктуры. Информация о разрешаемых IP-адресах должна быть представлена в виде экземпляра класса _Request_, на пример так:

```php
use Bricks\Business\Location\IpGeoBase\Request;

$request = new Request;

// Перечисление разрешаемых IP-адресов
$request->addTargetIp('1.1.1.1');
$request->addTargetIp('2.2.2.2');
$request->addTargetIp('3.3.3.3');
```

После подготовки запроса, он может быть передан для получения ответа:

```php
use Bricks\Business\Location\IpGeoBase\Resolver\CurlResolver;

// Подготовка Request

$resolver = new CurlResolver;
$response = $resolver->resolve($request);
```

Ответ представляется в виде экземпляра класса _Response_, хранящего коллекцию данных обо всех разрешаемых IP-адресах, которую удалось получить. Каждый разрешенный IP-адрес описывается экземпляром класса _IpInfo_ и может содержать следующую информацию:

* District - федеральный округ
* Region - регион
* City - город
* Location - географическое местоположение
* Message - дополнительное сообщение

```php
// Получение Response
echo $response->getCity()->getName();
```

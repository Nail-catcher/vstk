# sms_ru

PHP-класс для работы с api сервиса [sms.ru](http://sms.ru)

## Установка

### Предупреждение

Версия 4 имеет отличное от предыдущих версий API.

### Установка через Composer

Запустите

```
php composer.phar require zelenin/smsru "~4"
```

или добавьте

```js
"zelenin/smsru"
:
"~4"
```

в секцию ```require``` вашего composer.json

## Использование

Простая авторизация (с помощью api_id):

```php
$client = new \App\SmsRu\Api(new \App\SmsRu\Auth\ApiIdAuth($apiId));
```

Усиленная авторизация (с помощью api_id, логина и пароля):

```php
$client = new \App\SmsRu\Api(new \App\SmsRu\Auth\LoginPasswordSecureAuth($login, $password, $apiId));
```

Усиленная авторизация (с помощью логина и пароля):

```php
$client = new \App\SmsRu\Api(new \App\SmsRu\Auth\LoginPasswordAuth($login, $password));
```

Отправка SMS:

```php
$sms1 = new \App\SmsRu\Entity\Sms($phone1, $text1);
$sms1->translit = 1;
$sms2 = new \App\SmsRu\Entity\Sms($phone2, $text2);

$client->smsSend($sms1);
$client->smsSend($sms2);

$client->smsSend(new \App\SmsRu\Entity\SmsPool([$sms1, $sms2]));
```

Статус SMS:

```php
$send = $client->smsSend($sms);
$smsId = $send->ids[0];
$client->smsStatus($smsId);
```

Стоимость SMS:

```php
$client->smsCost(new \App\SmsRu\Entity\Sms($phone, $text));
```

Баланс:

```php
$client->myBalance();
```

Дневной лимит:

```php
$client->myLimit();
```

Отправители:

```php
$client->mySenders();
```

Проверка валидности логина и пароля:

```php
$client->authCheck();
```

Добавить номер в стоплист:

```php
$client->stoplistAdd($phone, $text);
```

Удалить номер из стоп-листа:

```php
$client->stoplistDel($phone);
```

Получить номера стоплиста:

```php
$client->stoplistGet();
```

## Автор

[Александр Зеленин](https://github.com/zelenin/), e-mail: [aleksandr@zelenin.me](mailto:aleksandr@zelenin.me)

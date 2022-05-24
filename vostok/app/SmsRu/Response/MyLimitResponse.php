<?php

namespace App\SmsRu\Response;

class MyLimitResponse extends AbstractResponse
{

    /**
     * @var int
     */
    public $limit;

    /**
     * @var int
     */
    public $current;

    /**
     * @var array
     */
    protected $availableDescriptions = [
        '100' => 'Запрос выполнен. На второй строчке вы найдете ваше текущее дневное ограничение. На третьей строчке количество сообщений, отправленных вами в текущий день.',
        '200' => 'Неправильный api_id.',
        '210' => 'Используется GET, где необходимо использовать POST.',
        '211' => 'Метод не найден.',
        '220' => 'Сервис временно недоступен, попробуйте чуть позже.',
        '300' => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился).',
        '301' => 'Неправильный пароль, либо пользователь не найден.',
        '302' => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс).',
    ];
}

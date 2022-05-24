<?php

namespace App\NotificationChannels\SmsRu;

use App\SmsRu\Auth\ApiIdAuth;
use Illuminate\Support\ServiceProvider;

class SmsRuServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(SmsRuApi::class, function ($app) {
            $apiId = $this->app['config']['services.sms.api_id'];
            $client = new SmsRuApi(new ApiIdAuth($apiId));

            return $client;
        });
    }

    public function provides(): array
    {
        return [
            SmsRuApi::class,
        ];
    }
}

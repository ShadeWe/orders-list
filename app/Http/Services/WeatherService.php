<?php

namespace App\Http\Services;

use GuzzleHttp\Client as Http;

class WeatherService
{
    /**
     * Получение температуры города по запрашиваемым координатам
     *
     * @param [type] $query
     * @return void
     */
    public static function Weather($query)
    {
        $client = new Http();

        $headers = [
            "X-Yandex-API-Key" => "833c7d4b-cbea-4ea0-9dd7-df2b0a7c8883"
        ];

        $response = $client->request('GET', "https://api.weather.yandex.ru/v2/forecast?" . http_build_query($query), [
            'headers' => $headers
        ]);

        $weather = json_decode((string)$response->getBody(), true);

        return [
            'city' => 'Брянск',
            'temperature' => $weather['fact']['temp'],
            'weather_icon' => $weather['fact']['icon']
        ];
    }
}
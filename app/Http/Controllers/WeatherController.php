<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\WeatherService;

class WeatherController extends Controller
{
    /**
     * Возвращает температуру города по координатам (г. Брянск)
     *
     * @return void
     */
    public function index()
    {
        return WeatherService::weather(http_build_query([
            'lat' => '53.2635',
            'lon' => '34.4161',
            'limit' => 1
        ]));
    }
}

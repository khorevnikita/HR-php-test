<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    /**
     * Return weather from lat/lon params using Yandex Weather API
     */
    public function index()
    {

        try {
            //53.243562, 34.363407
            $lat = "53.243562";
            $lon = "34.363407";
            $params = [
                "lat" => $lat,
                "lon" => $lon,
                "lang" => "en_US",
                "limit" => 1,
                "hours" => "false",
                "extra" => "false"
            ];
            $q = http_build_query($params);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, "https://api.weather.yandex.ru/v1/forecast?" . $q);
            //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
            //curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

// Only calling the head
            $headers = array('X-Yandex-API-Key: f73139c1-a640-4259-8ceb-aa550be7c613');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            //curl_setopt($ch, CURLOPT_HEADER, true); // header will be at output
            //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD'); // HTTP request is 'HEAD'

            $content = json_decode(curl_exec($ch));
            curl_close($ch);
            $forecast = $content->forecasts;
        } catch (\Exception $e) {
            Log::error("Error with forecast " . $e);
            return redirect("/")->with("error", "something went wrong");
        }

        return view("forecast.index", compact('forecast'));


    }
}

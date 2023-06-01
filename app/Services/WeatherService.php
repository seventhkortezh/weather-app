<?php

namespace App\Services;
use App\Helpers\GeocodeHelper;
use App\Helpers\MapperHelper;
use Illuminate\Support\Facades\Http;
use YaGeo;

/**
 * Класс сервис для работы с источником погоды
 * @author Alex Novikov <kortezh@list.ru>
 */
class WeatherService
{
    /**
     * Параметры из конфига источника (config/weatherProviders/*)
     */
    private $name;
    private $api_url;
    private $auth_type;
    private $request_type;
    private $api_key_title;
    private $api_key;
    private $identify_by_city;
    private $param_city_name;
    private $param_coord_name;
    private $response_type;
    private $response_map;

    /**
     * Типы авторизации
     */
    const AUTH_TOKEN = 'token';
    const AUTH_KEY = 'key';
    const AUTH_OAUTH = 'oauth';
    const AUTH_USERAGENT = 'user-agent';

    /**
     * Типы ответов от API
     */
    const RESPONSE_JSON = 'json';
    const RESPONSE_XML = 'xml';
    const RESPONSE_CSV = 'csv';

    public function __construct(string $weatherProvider)
    {
        try {

            $this->name = config('weatherProviders.' . $weatherProvider . '.name');

            $this->api_url = config('weatherProviders.' . $weatherProvider . '.api_url');
            $this->auth_type = config('weatherProviders.' . $weatherProvider . '.auth_type');
            $this->request_type = config('weatherProviders.' . $weatherProvider . '.request_type');
            $this->api_key_title = config('weatherProviders.' . $weatherProvider . '.api_key_title');
            $this->api_key = config('weatherProviders.' . $weatherProvider . '.api_key');

            $this->identify_by_city = config('weatherProviders.' . $weatherProvider . '.identify_by_city');
            $this->param_city_name = config('weatherProviders.' . $weatherProvider . '.param_city_name');
            $this->param_coord_name = config('weatherProviders.' . $weatherProvider . '.param_coord_name');

            $this->response_type = config('weatherProviders.' . $weatherProvider . '.response_type');
            $this->response_map = config('weatherProviders.' . $weatherProvider . '.response_map');

            $params = get_object_vars($this);

            foreach ($params as $key => $param)
            {
                if ( !isset($param) )
                {
                    throw new \Exception('Не задан параметр "' . $key . '" для источника "' . $weatherProvider . '"');
                }
            }

        } catch (Throwable $exception) {
            report($exception);

            return false;
        }

    }

    /**
     * Метод получает температуру по наименованию города
     * @param string $cityName название города
     * @return string|false
     */
    public function getTemperatureByCity(string $cityName):string|false
    {
        $data = $this->formatRequest($cityName);
        $response = $this->getResponse($data);

        return $response ? $this->formatData($response) : false;
    }

    /**
     * Метод формирует массив данных для запроса к API
     * Если API не поддерживает получение температуры по наименованию города,
     * то метод геокодирует по нему координаты
     * @param string $cityName наименование города
     * @return array
     */
    private function formatRequest(string $cityName):array
    {
        $data = [];

        if( $this->identify_by_city ){
            $data[$this->param_city_name] = $cityName;
        }else{
            $coord = GeocodeHelper::getCoordinates(YaGeo::setQuery($cityName)->load());

            if( $coord ) {
                $data[$this->param_coord_name['longitude']] = $coord['longitude'];
                $data[$this->param_coord_name['latitude']] = $coord['latitude'];
            }
        }

        return $data;
    }

    /**
     * Метод форматирует данные от API
     * @param \Illuminate\Http\Client\Response $response объект ответа от API
     * @return array|string|false
     */
    private function formatData(\Illuminate\Http\Client\Response $response):array|string|false
    {
        switch ($this->response_type){
            case self::RESPONSE_JSON:
                $formated = $response->json();
                break;

            case self::RESPONSE_XML:
                $formated = simplexml_load_string($response->body());
                $formated = json_decode(json_encode($formated), true);
                break;

            case self::RESPONSE_CSV:
                $formated = str_getcsv($response->body());
                break;

            default:
                $formated = false;
        }

        if( $this->response_map ){
            $formated = MapperHelper::handle($this->response_map, $formated);
        }

        return $formated;
    }

    /**
     * Метод отправляет запрос от API
     * @param array $data массив данных для запроса к API
     * @return \Illuminate\Http\Client\Response|false
     */
    private function getResponse(array $data):\Illuminate\Http\Client\Response|false
    {

        switch ($this->auth_type)
        {
            case self::AUTH_TOKEN:
                $response = Http::withHeaders([
                    $this->api_key_title => $this->api_key
                ])->get($this->api_url . '&' . http_build_query($data));
                break;
            case self::AUTH_KEY:
                $data[$this->api_key_title] = $this->api_key;
                $response = Http::get($this->api_url . '&' . http_build_query($data));
                break;
            case self::AUTH_USERAGENT:
                $response = Http::withHeaders([
                    'User-Agent' => $this->api_key
                ])->get($this->api_url . '&' . http_build_query($data));
                break;
            case self::AUTH_OAUTH:

                break;
            default:
                // none auth
                $response = Http::get($this->api_url . '&' . http_build_query($data));
        }

        return $response->successful() ? $response : false;
    }

}

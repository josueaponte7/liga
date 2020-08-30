<?php
// src/Service/ExternoService.php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
class ExternoService
{
    public function getMoney($precio)
    {
        $pr = 0;
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://api.exchangeratesapi.io/latest');
        $content = $response->toArray();
        $moneda = $content['rates']['USD'];
        $pr = $precio * $moneda;
        return $pr;
    }
}
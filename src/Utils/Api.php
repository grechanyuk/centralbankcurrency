<?php


namespace Grechanyuk\CentralBankCurrency\Utils;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class Api
{
    protected $base_uri = 'https://www.cbr.ru/scripts/';
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->base_uri]);
    }

    protected function get(string $url, array $params = [])
    {
        try {
            $response = $this->client->get($url, [
                'query' => $params
            ]);
        } catch (ClientException $e) {
            \Log::warning('CentralBankCurrency api error', ['message' => $e->getMessage(), 'code' => $e->getCode()]);
            return false;
        }

        return $this->answer($response);
    }

    private function answer(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 200) {
            $response = $response->getBody()->getContents();
            return new \SimpleXMLElement($response);
        }

        return false;
    }
}
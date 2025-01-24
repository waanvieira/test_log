<?php

namespace App\Gateway;

class UserGatewayService extends BaseRequestClientService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = getenv('EXTERNAL_GATEWAY_USER');
    }

    public function baseUrl()
    {
        return $this->baseUrl;
    }

    public function authorization(): array
    {
        return array();
    }

    protected function getHeader()
    {
        return [
            'Cache-Control' => 'no-cache',
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json'
        ];
    }

    public function getAllUser(array $filter)
    {
        $dataFiltered = $this->makeQueryParams($filter);
        return $this->get("$dataFiltered");
    }
}

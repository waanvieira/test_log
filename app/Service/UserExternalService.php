<?php

declare(strict_types=1);

namespace App\Service;

use App\Gateway\UserGatewayService;
use App\Repositories\Eloquent\UserExternalModelRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class UserExternalService
{
    const CACHE_TIME = 60 * 5;

    public function __construct(
        protected UserGatewayService $userGatewayService,
        protected UserExternalModelRepository $respository
    ) {}

    public function insertUser(array $data)
    {
        return $this->respository->insert($data);
    }

    public function insertUsersByExternalApi(array $data = [])
    {
        DB::transaction(function () use ($data) {
            $responses = $this->userGatewayService->getAllUser($data);
            foreach ($responses['results'] as $response) {
                $data = $this->formatPayloadInsert($response);
                $this->respository->insert($data);
            }
        });
    }

    public function getAllPaginateWithCache(string $filter = '', string $order = 'DESC', int $page = 1, int $totalPage = 15)
    {
        return Cache::remember("users_page_$page", self::CACHE_TIME, function ()  use ($filter, $order, $page, $totalPage) {
            return $this->respository->getAllPaginate($filter, $order, $page, $totalPage);
        });
    }

    public function formatPayloadInsert(array $payload)
    {
        $dataName = $payload["name"];
        return [
            "nome" => $dataName["title"] . " " . $dataName["first"] . " " . $dataName["last"],
            "email" => $payload["email"],
            "cidade" => $payload["location"]["city"],
            "telefone" => $payload["phone"],
            "foto" => $payload["picture"]["thumbnail"],
            "data_nascimento" => date('Y-m-d', strtotime($payload["registered"]["date"])),
        ];
    }
}

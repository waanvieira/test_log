<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseCrudEntityInterface
{
    public function insert(array $data): Model;
    public function findById(string $id): Model;
    public function update(array $data, string $id): Model;
    public function delete(string $id): bool;
    public function getAll(string $filter = '', $order = 'DESC'): array;
    public function getAllPaginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15);
}

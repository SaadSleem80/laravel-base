<?php

namespace App\Interfaces;

interface BaseRepositoryInterface
{
    public function fetchAll(array $filters): array;
    public function find(int $id): array;
    public function create(array $data): array;
    public function update(array $data, int $id): array;
    public function delete($id): void;
}
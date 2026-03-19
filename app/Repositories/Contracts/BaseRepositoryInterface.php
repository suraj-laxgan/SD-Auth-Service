<?php

namespace App\Repositories\Contracts;

interface BaseRepositoryInterface
{
    public function getAll(array $filters);
    public function findById(int $id);
    public function create(array $data);
    public function register(int $eventId, array $data);
}
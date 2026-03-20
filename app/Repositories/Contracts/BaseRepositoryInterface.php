<?php

namespace App\Repositories\Contracts;

interface BaseRepositoryInterface
{
    public function create(array $data);
    public function findByEmail(string $email);
}
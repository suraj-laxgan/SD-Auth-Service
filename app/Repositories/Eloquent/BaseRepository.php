<?php

namespace App\Repositories\Eloquent;

use App\Models\Event;
use App\Repositories\Contracts\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    public function getAll(array $filters)
    {
        
    }

    public function findById(int $id)
    {
    }

    public function create(array $data)
    {
    }

    public function register(int $eventId, array $data)
    {
       
    }
}
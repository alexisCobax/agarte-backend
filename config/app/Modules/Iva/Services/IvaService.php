<?php

namespace App\Modules\Iva\Services;

use PDOException;
use App\Modules\Iva\Repositories\IvaRepository;

class IvaService
{
    public function create($request)
    {
    //--
    }

    public function getAll(): array
    {
        $items = IvaRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentra condicion de iva.');
        }
        return $items;
    }

    public function get($request)
    {
    //--
    }

    public function update($request)
    {
    //--
    }

    public function delete($request)
    {
    //--
    }
}
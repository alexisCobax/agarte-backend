<?php

namespace App\Modules\Localidades\Services;

use PDOException;
use App\Modules\Localidades\Repositories\LocalidadesRepository;

class LocalidadesService
{
    public function create($request)
    {
        //--
    }

    public function getAll(): array
    {
        $items = LocalidadesRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran localidades.');
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

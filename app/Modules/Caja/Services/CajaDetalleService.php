<?php

namespace App\Modules\Caja\Services;

use PDOException;
use App\Modules\Caja\Repositories\CajaDetalleRepository;
use App\Modules\Auth\Services\AuthService;

class CajaDetalleService
{

    public function getAll($request): array
    {
        $items = CajaDetalleRepository::find($request);

        if (!$items) {
            throw new \Exception('No se encuentran Cajas.');
        }
        return $items;
    }

   

 
}
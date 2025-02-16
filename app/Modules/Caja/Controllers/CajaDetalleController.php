<?php

namespace App\Modules\Caja\Controllers;

use App\Modules\Caja\Requests\CajaDeatlleRequest;
use App\Modules\Auth\Requests\AuthRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Caja\Services\CajaDetalleService;

class CajaDetalleController
{

    public function index($request)
    {
        $service = new CajaDetalleService;

        try {
            $response = $service->getAll($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }



}
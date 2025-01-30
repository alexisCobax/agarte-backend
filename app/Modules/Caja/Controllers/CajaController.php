<?php

namespace App\Modules\Caja\Controllers;

use App\Modules\Caja\Requests\CajaShowRequest;
use App\Modules\Caja\Requests\CajaCreateRequest;
use App\Modules\Caja\Requests\CajaDeleteRequest;
use App\Modules\Caja\Requests\CajaUpdateRequest;
use App\Modules\Auth\Requests\AuthRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Caja\Services\CajaService;

class CajaController
{

    public function index()
    {
        $service = new CajaService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(CajaShowRequest $request)
    {
        $service = new CajaService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(CajaCreateRequest $requestCaja, AuthRequest $requestAuth)
    {
        
        $service = new CajaService;

        try {
            $response = $service->create($requestCaja,$requestAuth);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(CajaUpdateRequest $requestCaja, AuthRequest $requestAuth)
    {
        $service = new CajaService;
        

        try {
            $response = $service->update($requestCaja,$requestAuth);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(CajaDeleteRequest $request)
    {
        $service = new CajaService;

        try {
            $service->delete($request);
            ResponseHelper::success('Caja borrada con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
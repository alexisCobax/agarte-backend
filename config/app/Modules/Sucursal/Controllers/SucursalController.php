<?php

namespace App\Modules\Sucursal\Controllers;

use App\Modules\Sucursal\Requests\SucursalShowRequest;
use App\Modules\Sucursal\Requests\SucursalCreateRequest;
use App\Modules\Sucursal\Requests\SucursalDeleteRequest;
use App\Modules\Sucursal\Requests\SucursalUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Sucursal\Services\SucursalService;

class SucursalController
{

    public function index()
    {
        $service = new SucursalService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(SucursalShowRequest $request)
    {
        $service = new SucursalService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(SucursalCreateRequest $request)
    {
        $service = new SucursalService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(SucursalUpdateRequest $request)
    {
        $service = new SucursalService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(SucursalDeleteRequest $request)
    {
        $service = new SucursalService;

        try {
            $service->delete($request);
            ResponseHelper::success('Sucursal borrada con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}

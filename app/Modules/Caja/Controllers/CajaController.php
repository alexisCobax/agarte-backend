<?php

namespace App\Modules\Caja\Controllers;

use App\Support\Request;
use App\Helpers\ResponseHelper;
use App\Modules\Auth\Requests\AuthRequest;
use App\Modules\Caja\Services\CajaService;
use App\Modules\Caja\Requests\CajaShowRequest;
use App\Modules\Caja\Requests\CajaCreateRequest;
use App\Modules\Caja\Requests\CajaDeleteRequest;
use App\Modules\Caja\Requests\CajaUpdateRequest;

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

    public function show(Request $request)
    {
        $service = new CajaService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(Request $requestCaja, AuthRequest $requestAuth)
    {
        
        $service = new CajaService;

        try {
            $response = $service->create($requestCaja,$requestAuth);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(Request $requestCaja, AuthRequest $requestAuth)
    {
        $service = new CajaService;
        

        try {
            $response = $service->update($requestCaja,$requestAuth);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $service = new CajaService;

        try {
            $service->delete($request);
            ResponseHelper::success([]);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function pdf(Request $request, $id)
    {
        $service = new CajaService;

        try {
            $service->pdfCaja($request, $id);
            ResponseHelper::success([]);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
<?php

namespace App\Modules\Presupuesto\Controllers;

use App\Helpers\ResponseHelper;
use App\Modules\Presupuesto\Services\PresupuestosExtrasService;
use App\Modules\Presupuesto\Requests\PresupuestosExtrasShowRequest;
use App\Modules\Presupuesto\Requests\PresupuestosExtrasCreateRequest;
use App\Modules\Presupuesto\Requests\PresupuestosExtrasDeleteRequest;
use App\Modules\Presupuesto\Requests\PresupuestosExtrasUpdateRequest;

class PresupuestoExtrasController
{

    public function index()
    {
        $service = new PresupuestosExtrasService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(PresupuestosExtrasShowRequest $request)
    {
        $service = new PresupuestosExtrasService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(PresupuestosExtrasCreateRequest $request)
    {
        $service = new PresupuestosExtrasService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(PresupuestosExtrasUpdateRequest $request)
    {
        $service = new PresupuestosExtrasService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(PresupuestosExtrasDeleteRequest $request)
    {
        $service = new PresupuestosExtrasService;

        try {
            $service->delete($request);
            ResponseHelper::success('Presupuesto Extra borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
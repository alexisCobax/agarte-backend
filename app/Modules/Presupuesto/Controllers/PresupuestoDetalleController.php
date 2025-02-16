<?php

namespace App\Modules\Presupuesto\Controllers;

use App\Helpers\ResponseHelper;
use App\Modules\Presupuesto\Services\PresupuestosDetalleService;
use App\Modules\Presupuesto\Requests\PresupuestosDetalleShowRequest;
use App\Modules\Presupuesto\Requests\PresupuestosDetalleCreateRequest;
use App\Modules\Presupuesto\Requests\PresupuestosDetalleDeleteRequest;
use App\Modules\Presupuesto\Requests\PresupuestosDetalleUpdateRequest;
use App\Modules\Presupuesto\Requests\PresupuestosDetalleUpdatePosiciones;
use App\Modules\Presupuesto\Requests\PresupuestosDetalleUpdateObservaciones;
use App\Support\Request;

class PresupuestoDetalleController
{

    public function index()
    {
        $service = new PresupuestosDetalleService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(PresupuestosDetalleShowRequest $request)
    {
        $service = new PresupuestosDetalleService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(PresupuestosDetalleCreateRequest $request)
    {
        $service = new PresupuestosDetalleService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(PresupuestosDetalleUpdateRequest $request)
    {
        $service = new PresupuestosDetalleService;

        try {
            $response = $service->update($request);
            ResponseHelper::success([$response]);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(PresupuestosDetalleDeleteRequest $request)
    {
        $service = new PresupuestosDetalleService;

        try {
            $service->delete($request);
            ResponseHelper::success(['DetallePresupuesto borrado con éxito']);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function updateObservaciones(PresupuestosDetalleUpdateObservaciones $request)
    {

        $service = new PresupuestosDetalleService;

        try {
            $response = $service->updateObservaciones($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function updatePosiciones(PresupuestosDetalleUpdatePosiciones $request)
    {
        $service = new PresupuestosDetalleService;

        try {
            $response = $service->updatePosiciones($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function updateCm(Request $request)
    {
        $service = new PresupuestosDetalleService;

        try {
            $response = $service->updateCm($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function updateCs(Request $request)
    {
        $service = new PresupuestosDetalleService;

        try {
            $response = $service->updateCs($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
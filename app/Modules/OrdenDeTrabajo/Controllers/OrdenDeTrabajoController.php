<?php

namespace App\Modules\OrdenDeTrabajo\Controllers;

use App\Support\Request;
use App\Helpers\ResponseHelper;
use App\Modules\OrdenDeTrabajo\Services\OrdenDeTrabajoService;
use App\Modules\Presupuesto\Requests\PresupuestosUpdateRequest;
use App\Modules\OrdenDeTrabajo\Requests\OrdenDeTrabajoShowRequest;
use App\Modules\OrdenDeTrabajo\Requests\OrdenDeTrabajoCreateRequest;
use App\Modules\OrdenDeTrabajo\Requests\OrdenDeTrabajoDeleteRequest;
use App\Modules\OrdenDeTrabajo\Requests\OrdenDeTrabajoUpdateRequest;

class OrdenDeTrabajoController
{

    public function index()
    {
        $service = new OrdenDeTrabajoService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(OrdenDeTrabajoShowRequest $request)
    {
        $service = new OrdenDeTrabajoService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {   
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(PresupuestosUpdateRequest $request)
    {
        $service = new OrdenDeTrabajoService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function generate(Request $request)
    {
        $service = new OrdenDeTrabajoService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(OrdenDeTrabajoUpdateRequest $request)
    {
        $service = new OrdenDeTrabajoService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(OrdenDeTrabajoDeleteRequest $request)
    {
        $service = new OrdenDeTrabajoService;

        try {
            $service->delete($request);
            ResponseHelper::success(['Orden borrado con éxito']);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
    public function pdf($id)
    {
        $service = new OrdenDeTrabajoService;

        try {
            $service->pdf($id);
            ResponseHelper::success(['Orden borrado con éxito']);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
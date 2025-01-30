<?php

namespace App\Modules\OrdenDeTrabajo\Controllers;

use App\Modules\OrdenDeTrabajo\Requests\EstadosOrdenTrabajoCreateRequest;
use App\Modules\OrdenDeTrabajo\Requests\EstadosOrdenTrabajoShowRequest;
use App\Modules\OrdenDeTrabajo\Requests\EstadosOrdenTrabajoDeleteRequest;
use App\Modules\OrdenDeTrabajo\Requests\EstadosOrdenTrabajoUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\OrdenDeTrabajo\Services\OrdenDeTrabajoEstadoService;

class OrdenDeTrabajoEstadosController
{

    public function index()
    {
        $service = new OrdenDeTrabajoEstadoService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(EstadosOrdenTrabajoShowRequest $request)
    {
        $service = new OrdenDeTrabajoEstadoService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(EstadosOrdenTrabajoCreateRequest $request)
    {
        $service = new OrdenDeTrabajoEstadoService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(EstadosOrdenTrabajoUpdateRequest $request)
    {
        $service = new OrdenDeTrabajoEstadoService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(EstadosOrdenTrabajoDeleteRequest $request)
    {
        $service = new OrdenDeTrabajoEstadoService;

        try {
            $service->delete($request);
            ResponseHelper::success(['Orden borrado con éxito']);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
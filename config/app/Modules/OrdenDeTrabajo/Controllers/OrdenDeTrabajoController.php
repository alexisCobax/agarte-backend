<?php

namespace App\Modules\OrdenDeTrabajo\Controllers;

use App\Modules\OrdenDeTrabajo\Requests\OrdenDeTrabajoShowRequest;
use App\Modules\OrdenDeTrabajo\Requests\OrdenDeTrabajoCreateRequest;
use App\Modules\OrdenDeTrabajo\Requests\OrdenDeTrabajoDeleteRequest;
use App\Modules\OrdenDeTrabajo\Requests\OrdenDeTrabajoUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\OrdenDeTrabajo\Services\OrdenDeTrabajoService;

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


    public function create(OrdenDeTrabajoCreateRequest $request)
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
            ResponseHelper::success('Orden borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
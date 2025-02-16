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

    public function indexAll()
    {
        $service = new OrdenDeTrabajoService;

        try {
            $response = $service->getAllOrders();
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

    public function generar(Request $request)
    {
        $service = new OrdenDeTrabajoService;

        try {
            $response = $service->generar($request);
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

    public function updateStatus(Request $request)
    {
        $service = new OrdenDeTrabajoService;

        try {
            $response = $service->updateStatus($request);
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

    public function pdfOrdenCliente($id)
    {
        $service = new OrdenDeTrabajoService;

        try {
            $service->pdfOrdenCliente($id);
            ResponseHelper::success(['Orden borrado con éxito']);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function pdfOrdenTaller($id)
    {

        $service = new OrdenDeTrabajoService;

        try {
            $service->pdfOrdenTaller($id);
            ResponseHelper::success(['Orden borrado con éxito']);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
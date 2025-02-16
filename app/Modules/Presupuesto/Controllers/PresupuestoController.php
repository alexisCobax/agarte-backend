<?php

namespace App\Modules\Presupuesto\Controllers;

use App\Support\Request;
use App\Helpers\ResponseHelper;
use App\Modules\Presupuesto\Services\PresupuestosService;
use App\Modules\Presupuesto\Requests\PresupuestosShowRequest;
use App\Modules\Presupuesto\Requests\PresupuestosCreateRequest;
use App\Modules\Presupuesto\Requests\PresupuestosDeleteRequest;
use App\Modules\Presupuesto\Requests\PresupuestosUpdateRequest;

class PresupuestoController
{

    public function index()
    {
        $service = new PresupuestosService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(PresupuestosShowRequest $request)
    {
        $service = new PresupuestosService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
    
    public function createOrUpdate(
        PresupuestosCreateRequest $createRequest,
        PresupuestosUpdateRequest $updateRequest
    ) {

        $service = new PresupuestosService;
    
        try {
            $response = $service->createOrUpdate($createRequest, $updateRequest);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
    

    public function create(PresupuestosCreateRequest $request)
    {
        $service = new PresupuestosService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(PresupuestosUpdateRequest $request)
    {
        $service = new PresupuestosService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(PresupuestosDeleteRequest $request)
    {
        $service = new PresupuestosService;

        try {
            $service->delete($request);
            ResponseHelper::success(['Presupuesto borrado con éxito']);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function pdfPresupuesto($id)
    {

        $service = new PresupuestosService;

        try {
            $service->pdfPresupuesto($id);
            ResponseHelper::success(['Presupuesto generado con exito']);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
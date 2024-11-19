<?php

namespace App\Modules\Empleado\Controllers;

use App\Modules\Empleado\Requests\EmpleadosShowRequest;
use App\Modules\Empleado\Requests\EmpleadosCreateRequest;
use App\Modules\Empleado\Requests\EmpleadosDeleteRequest;
use App\Modules\Empleado\Requests\EmpleadosUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Empleado\Services\EmpleadosService;

class EmpleadoController
{

    public function index()
    {
        $service = new EmpleadosService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(EmpleadosShowRequest $request)
    {
        $service = new EmpleadosService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(EmpleadosCreateRequest $request)
    {
        $service = new EmpleadosService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(EmpleadosUpdateRequest $request)
    {
        $service = new EmpleadosService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(EmpleadosDeleteRequest $request)
    {
        $service = new EmpleadosService;

        try {
            $service->delete($request);
            ResponseHelper::success('Empleado borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
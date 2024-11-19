<?php

namespace App\Modules\Recibo\Controllers;

use App\Modules\Recibo\Requests\RecibosShowRequest;
use App\Modules\Recibo\Requests\RecibosCreateRequest;
use App\Modules\Recibo\Requests\RecibosDeleteRequest;
use App\Modules\Recibo\Requests\RecibosUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Recibo\Services\RecibosService;

class ReciboController
{

    public function index()
    {
        $service = new RecibosService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(RecibosShowRequest $request)
    {
        $service = new RecibosService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(RecibosCreateRequest $request)
    {
        $service = new RecibosService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(RecibosUpdateRequest $request)
    {
        $service = new RecibosService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(RecibosDeleteRequest $request)
    {
        $service = new RecibosService;

        try {
            $service->delete($request);
            ResponseHelper::success('Recibo borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
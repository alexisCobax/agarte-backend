<?php

namespace App\Modules\FormaDePago\Controllers;

use App\Modules\FormaDePago\Requests\FormaDePagoShowRequest;
use App\Modules\FormaDePago\Requests\FormaDePagoCreateRequest;
use App\Modules\FormaDePago\Requests\FormaDePagoDeleteRequest;
use App\Modules\FormaDePago\Requests\FormaDePagoUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\FormaDePago\Services\FormaDePagoService;

class FormaDePagoController
{

    public function index()
    {
        $service = new FormaDePagoService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(FormaDePagoShowRequest $request)
    {
        $service = new FormaDePagoService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(FormaDePagoCreateRequest $request)
    {
        $service = new FormaDePagoService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(FormaDePagoUpdateRequest $request)
    {
        $service = new FormaDePagoService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(FormaDePagoDeleteRequest $request)
    {
        $service = new FormaDePagoService;

        try {
            $service->delete($request);
            ResponseHelper::success('Forma de Pago borrada con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}

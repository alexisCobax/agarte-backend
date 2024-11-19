<?php

namespace App\Modules\Orden\Controllers;

use App\Modules\Orden\Requests\OrdenShowRequest;
use App\Modules\Orden\Requests\OrdenCreateRequest;
use App\Modules\Orden\Requests\OrdenDeleteRequest;
use App\Modules\Orden\Requests\OrdenUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Orden\Services\OrdenService;

class OrdenController
{

    public function index()
    {
        $service = new OrdenService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(OrdenShowRequest $request)
    {
        $service = new OrdenService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(OrdenCreateRequest $request)
    {
        $service = new OrdenService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(OrdenUpdateRequest $request)
    {
        $service = new OrdenService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(OrdenDeleteRequest $request)
    {
        $service = new OrdenService;

        try {
            $service->delete($request);
            ResponseHelper::success('Orden borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
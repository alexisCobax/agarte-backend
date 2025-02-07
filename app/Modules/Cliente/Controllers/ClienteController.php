<?php

namespace App\Modules\Cliente\Controllers;

use App\Modules\Cliente\Requests\ClientesShowRequest;
use App\Modules\Cliente\Requests\ClientesCreateRequest;
use App\Modules\Cliente\Requests\ClientesDeleteRequest;
use App\Modules\Cliente\Requests\ClientesUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Cliente\Services\ClientesService;

class ClienteController
{

    public function index()
    {
        $service = new ClientesService;
        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(ClientesShowRequest $request)
    {
        $service = new ClientesService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(ClientesCreateRequest $request)
    {
        $service = new ClientesService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(ClientesUpdateRequest $request)
    {
        $service = new ClientesService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(ClientesDeleteRequest $request)
    {
        $service = new ClientesService;

        try {
            $service->delete($request);
            ResponseHelper::success(['Cliente borrado con éxito']);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
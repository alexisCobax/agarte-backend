<?php

namespace App\Modules\Rol\Controllers;

use App\Modules\Rol\Requests\RolShowRequest;
use App\Modules\Rol\Requests\RolCreateRequest;
use App\Modules\Rol\Requests\RolDeleteRequest;
use App\Modules\Rol\Requests\RolUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Rol\Services\RolService;

class RolController
{

    public function index()
    {
        $service = new RolService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(RolShowRequest $request)
    {
        $service = new RolService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(RolCreateRequest $request)
    {
        $service = new RolService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(RolUpdateRequest $request)
    {
        $service = new RolService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(RolDeleteRequest $request)
    {
        $service = new RolService;

        try {
            $service->delete($request);
            ResponseHelper::success('Rol borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}

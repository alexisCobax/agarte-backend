<?php

namespace App\Modules\Materiales\Controllers;

use App\Modules\Materiales\Requests\MaterialesShowRequest;
use App\Modules\Materiales\Requests\MaterialesCreateRequest;
use App\Modules\Materiales\Requests\MaterialesDeleteRequest;
use App\Modules\Materiales\Requests\MaterialesUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Materiales\Services\MaterialesService;

class MaterialesController
{

    public function index()
    {
        $service = new MaterialesService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(MaterialesShowRequest $request)
    {
        $service = new MaterialesService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(MaterialesCreateRequest $request)
    {
        $service = new MaterialesService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(MaterialesUpdateRequest $request)
    {
        $service = new MaterialesService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(MaterialesDeleteRequest $request)
    {
        $service = new MaterialesService;

        try {
            $service->delete($request);
            ResponseHelper::success('Materiale borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
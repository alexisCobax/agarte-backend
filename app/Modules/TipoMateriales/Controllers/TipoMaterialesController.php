<?php

namespace App\Modules\TipoMateriales\Controllers;

use App\Modules\TipoMateriales\Requests\TipoMaterialesShowRequest;
use App\Modules\TipoMateriales\Requests\TipoMaterialesCreateRequest;
use App\Modules\TipoMateriales\Requests\TipoMaterialesDeleteRequest;
use App\Modules\TipoMateriales\Requests\TipoMaterialesUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\TipoMateriales\Services\TipoMaterialesService;

class TipoMaterialesController
{

    public function index()
    {
        $service = new TipoMaterialesService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(TipoMaterialesShowRequest $request)
    {
        $service = new TipoMaterialesService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(TipoMaterialesCreateRequest $request)
    {
        $service = new TipoMaterialesService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(TipoMaterialesUpdateRequest $request)
    {
        $service = new TipoMaterialesService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(TipoMaterialesDeleteRequest $request)
    {
        $service = new TipoMaterialesService;

        try {
            $service->delete($request);
            ResponseHelper::success('Tipo de materiales borrada con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}

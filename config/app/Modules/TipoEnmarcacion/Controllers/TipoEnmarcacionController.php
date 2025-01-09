<?php

namespace App\Modules\TipoEnmarcacion\Controllers;

use App\Helpers\ResponseHelper;
use App\Modules\TipoEnmarcacion\Requests\TipoEnmarcacionShowRequest;
use App\Modules\TipoEnmarcacion\Requests\TipoEnmarcacionCreateRequest;
use App\Modules\TipoEnmarcacion\Requests\TipoEnmarcacionDeleteRequest;
use App\Modules\TipoEnmarcacion\Requests\TipoEnmarcacionUpdateRequest;
use App\Modules\TipoEnmarcacion\Services\TipoEnmarcacionService;

class TipoEnmarcacionController
{
    public function index()
    {
        $service = new TipoEnmarcacionService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(TipoEnmarcacionShowRequest $request)
    {
        $service = new TipoEnmarcacionService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(TipoEnmarcacionCreateRequest $request)
    {
        $service = new TipoEnmarcacionService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(TipoEnmarcacionUpdateRequest $request)
    {
        $service = new TipoEnmarcacionService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(TipoEnmarcacionDeleteRequest $request)
    {
        $service = new TipoEnmarcacionService;

        try {
            $service->delete($request);
            ResponseHelper::success('Tipo enmarcación borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}

<?php

namespace App\Modules\TipoEnmarcacion\Controllers;

use App\Helpers\ResponseHelper;
use App\Modules\TipoEnmarcacion\Services\TipoEnmarcacionService;

class TipoEnmarcacionController
{
    public function index() {
        $service = new TipoEnmarcacionService;
        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show() {
        $service = new TipoEnmarcacionService;
        try {
            $response = $service->get();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function create() {
        $service = new TipoEnmarcacionService;
        try {
            $response = $service->create();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update() {
        $service = new TipoEnmarcacionService;
        try {
            $response = $service->update();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete() {
        $service = new TipoEnmarcacionService;
        try {
            $service->delete();
            ResponseHelper::success('Dato borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}

<?php

namespace App\Modules\ObjetosEnmarcar\Controllers;

use App\Helpers\ResponseHelper;
use App\Modules\ObjetosEnmarcar\Services\ObjetosEnmarcarService;

class ObjetosEnmarcarController
{
    public function index() {
        $service = new ObjetosEnmarcarService;
        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show() {
        $service = new ObjetosEnmarcarService;
        try {
            $response = $service->get();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function create() {
        $service = new ObjetosEnmarcarService;
        try {
            $response = $service->create();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update() {
        $service = new ObjetosEnmarcarService;
        try {
            $response = $service->update();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete() {
        $service = new ObjetosEnmarcarService;
        try {
            $service->delete();
            ResponseHelper::success('Dato borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}

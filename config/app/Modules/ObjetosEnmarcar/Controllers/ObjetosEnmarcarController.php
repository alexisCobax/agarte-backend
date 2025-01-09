<?php

namespace App\Modules\ObjetosEnmarcar\Controllers;

use App\Helpers\ResponseHelper;
use App\Modules\ObjetosEnmarcar\Services\ObjetosEnmarcarService;
use App\Modules\ObjetosEnmarcar\Requests\ObjetosEnmarcarCreateRequest;
use App\Modules\ObjetosEnmarcar\Requests\ObjetosEnmarcarUpdateRequest;
use App\Modules\ObjetosEnmarcar\Requests\ObjetosEnmarcarShowRequest;
use App\Modules\ObjetosEnmarcar\Requests\ObjetosEnmarcarDeleteRequest;

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

    public function show(ObjetosEnmarcarShowRequest $request) {
        $service = new ObjetosEnmarcarService;
        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function create(ObjetosEnmarcarCreateRequest $request) {
        $service = new ObjetosEnmarcarService;
        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(ObjetosEnmarcarUpdateRequest $request) {
        $service = new ObjetosEnmarcarService;
        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(ObjetosEnmarcarDeleteRequest $request) {
        $service = new ObjetosEnmarcarService;
        try {
            $service->delete($request);
            ResponseHelper::success('Objeto a enmarcar borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}

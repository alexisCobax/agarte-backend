<?php

namespace App\Modules\Localidades\Controllers;

use App\Helpers\ResponseHelper;
use App\Modules\Localidades\Services\LocalidadesService;

class LocalidadesController
{

    public function index()
    {
        $service = new LocalidadesService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show()
    {
        //--
    }


    public function create()
    {
        //--
    }

    public function update()
    {
        //--
    }

    public function delete()
    {
        //--
    }
}

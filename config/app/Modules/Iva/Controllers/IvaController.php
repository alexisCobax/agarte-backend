<?php

namespace App\Modules\Iva\Controllers;

use App\Helpers\ResponseHelper;
use App\Modules\Iva\Services\IvaService;

class IvaController
{

    public function index()
    {
        $service = new IvaService;

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

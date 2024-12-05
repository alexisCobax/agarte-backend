<?php

namespace App\Modules\Documentos\Controllers;

use App\Helpers\ResponseHelper;
use App\Modules\Documentos\Services\DocumentosService;

class DocumentosController
{

    public function index()
    {
        $service = new DocumentosService;

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

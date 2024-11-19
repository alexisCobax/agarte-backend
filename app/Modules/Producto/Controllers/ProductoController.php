<?php

namespace App\Modules\Producto\Controllers;

use App\Modules\Producto\Requests\ProductosShowRequest;
use App\Modules\Producto\Requests\ProductosCreateRequest;
use App\Modules\Producto\Requests\ProductosDeleteRequest;
use App\Modules\Producto\Requests\ProductosUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Modules\Producto\Services\ProductosService;

class ProductoController
{

    public function index()
    {
        $service = new ProductosService;

        try {
            $response = $service->getAll();
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function show(ProductosShowRequest $request)
    {
        $service = new ProductosService;

        try {
            $response = $service->get($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }


    public function create(ProductosCreateRequest $request)
    {
        $service = new ProductosService;

        try {
            $response = $service->create($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function update(ProductosUpdateRequest $request)
    {
        $service = new ProductosService;

        try {
            $response = $service->update($request);
            ResponseHelper::success($response);
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }

    public function delete(ProductosDeleteRequest $request)
    {
        $service = new ProductosService;

        try {
            $service->delete($request);
            ResponseHelper::success('Producto borrado con éxito');
        } catch (\Exception $e) {
            ResponseHelper::error($e->getMessage());
        }
    }
}
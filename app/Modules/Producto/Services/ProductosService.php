<?php

namespace App\Modules\Producto\Services;

use PDOException;
use App\Modules\Producto\Repositories\ProductosRepository;

class ProductosService
{
    public function create($request): array
    {
        try {
            $item = ProductosRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un productos. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = ProductosRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran productos.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = ProductosRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra productos.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = ProductosRepository::update($request);
            if (!$item) {
                throw new \Exception('Productos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un productos. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = ProductosRepository::delete($request);
            if (!$item) {
                throw new \Exception('Productos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un productos. Inténtalo más tarde.');
        }
    }
}
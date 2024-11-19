<?php

namespace App\Modules\Presupuesto\Services;

use PDOException;
use App\Modules\Presupuesto\Repositories\PresupuestosDetalleRepository;

class PresupuestosDetalleService
{
    public function create($request): array
    {
        try {
            $item = PresupuestosDetalleRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un presupuestosdetalle. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = PresupuestosDetalleRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran presupuestosdetallees.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = PresupuestosDetalleRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra presupuestosdetalle.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = PresupuestosDetalleRepository::update($request);
            if (!$item) {
                throw new \Exception('PresupuestosDetalle inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un presupuestosdetalle. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = PresupuestosDetalleRepository::delete($request);
            if (!$item) {
                throw new \Exception('PresupuestosDetalle inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un presupuestosdetalle. Inténtalo más tarde.');
        }
    }
}
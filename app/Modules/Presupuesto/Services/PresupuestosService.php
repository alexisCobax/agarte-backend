<?php

namespace App\Modules\Presupuesto\Services;

use PDOException;
use App\Modules\Presupuesto\Repositories\PresupuestosRepository;

class PresupuestosService
{
    public function create($request): array
    {
        try {
            $item = PresupuestosRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un presupuestos. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = PresupuestosRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran presupuestos.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = PresupuestosRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra presupuestos.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = PresupuestosRepository::update($request);
            if (!$item) {
                throw new \Exception('Presupuestos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un presupuestos. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = PresupuestosRepository::delete($request);
            if (!$item) {
                throw new \Exception('Presupuestos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un presupuestos. Inténtalo más tarde.');
        }
    }
}
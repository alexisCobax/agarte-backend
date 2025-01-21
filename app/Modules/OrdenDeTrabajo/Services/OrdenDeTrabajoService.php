<?php

namespace App\Modules\OrdenDeTrabajo\Services;

use PDOException;
use App\Modules\OrdenDeTrabajo\Repositories\OrdenDeTrabajoRepository;

class OrdenDeTrabajoService
{
    public function create($request): array
    {
        try {
            $item = OrdenDeTrabajoRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear unn ordendetrabajo. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = OrdenDeTrabajoRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran ordenes de trabajos.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = OrdenDeTrabajoRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra ordendetrabajo.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = OrdenDeTrabajoRepository::update($request);
            if (!$item) {
                throw new \Exception('OrdenDeTrabajo inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar unn ordendetrabajo. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = OrdenDeTrabajoRepository::delete($request);
            if (!$item) {
                throw new \Exception('OrdenDeTrabajo inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar unn ordendetrabajo. Inténtalo más tarde.');
        }
    }
}
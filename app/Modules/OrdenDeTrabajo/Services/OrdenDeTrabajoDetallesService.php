<?php

namespace App\Modules\Orden\Services;

use PDOException;
use App\Modules\Orden\Repositories\OrdenDeTrabajoDetallesRepository;

class OrdenDeTrabajoDetallesService
{
    public function create($request): array
    {
        try {
            $item = OrdenDeTrabajoDetallesRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear unn ordendetrabajodetalles. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = OrdenDeTrabajoDetallesRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran ordendetrabajodetalles.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = OrdenDeTrabajoDetallesRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra ordendetrabajodetalles.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = OrdenDeTrabajoDetallesRepository::update($request);
            if (!$item) {
                throw new \Exception('OrdenDeTrabajoDetalles inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar unn ordendetrabajodetalles. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = OrdenDeTrabajoDetallesRepository::delete($request);
            if (!$item) {
                throw new \Exception('OrdenDeTrabajoDetalles inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar unn ordendetrabajodetalles. Inténtalo más tarde.');
        }
    }
}
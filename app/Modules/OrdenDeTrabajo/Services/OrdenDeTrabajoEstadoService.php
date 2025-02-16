<?php

namespace App\Modules\OrdenDeTrabajo\Services;

use PDOException;
use App\Modules\OrdenDeTrabajo\Repositories\EstadosOrdenTrabajoRepository;

class OrdenDeTrabajoEstadoService
{
    public function create($request): array
    {
        try {
            $item = EstadosOrdenTrabajoRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear unn estados orden trabajo. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = EstadosOrdenTrabajoRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran estados orden trabajo.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = EstadosOrdenTrabajoRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra estados orden trabajo.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = EstadosOrdenTrabajoRepository::update($request);
            if (!$item) {
                throw new \Exception('EstadosOrdenTrabajo inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar unn estados orden trabajo. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = EstadosOrdenTrabajoRepository::delete($request);
            if (!$item) {
                throw new \Exception('EstadosOrdenTrabajo inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar unn estados orden trabajo. Inténtalo más tarde.');
        }
    }
}
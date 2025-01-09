<?php

namespace App\Modules\Orden\Services;

use PDOException;
use App\Modules\Orden\Repositories\EstadosOrdenTrabajoRepository;

class EstadosOrdenTrabajoService
{
    public function create($request): array
    {
        try {
            $item = EstadosOrdenTrabajoRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear unn estadosordentrabajo. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = EstadosOrdenTrabajoRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran estadosordentrabajoes.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = EstadosOrdenTrabajoRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra estadosordentrabajo.');
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
            throw new \Exception('Error al modificar unn estadosordentrabajo. Inténtalo más tarde.');
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
            throw new \Exception('Error al eliminar unn estadosordentrabajo. Inténtalo más tarde.');
        }
    }
}
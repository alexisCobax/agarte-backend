<?php

namespace App\Modules\Empleado\Services;

use PDOException;
use App\Modules\Empleado\Repositories\EmpleadosRepository;

class EmpleadosService
{
    public function create($request): array
    {
        try {
            $item = EmpleadosRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear unn empleados. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = EmpleadosRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran empleados.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = EmpleadosRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra empleados.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = EmpleadosRepository::update($request);
            if (!$item) {
                throw new \Exception('Empleados inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar unn empleados. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = EmpleadosRepository::delete($request);
            if (!$item) {
                throw new \Exception('Empleados inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar unn empleados. Inténtalo más tarde.');
        }
    }
}
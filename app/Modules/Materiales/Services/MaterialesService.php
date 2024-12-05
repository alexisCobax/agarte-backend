<?php

namespace App\Modules\Materiales\Services;

use PDOException;
use App\Modules\Materiales\Repositories\MaterialesRepository;

class MaterialesService
{
    public function create($request): array
    {
        try {
            $item = MaterialesRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un Materiales. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = MaterialesRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran Materiales.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = MaterialesRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra Materiales.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = MaterialesRepository::update($request);
            if (!$item) {
                throw new \Exception('Materiales inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un Materiales. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = MaterialesRepository::delete($request);
            if (!$item) {
                throw new \Exception('Materiales inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un Materiales. Inténtalo más tarde.');
        }
    }
}
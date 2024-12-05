<?php

namespace App\Modules\Cliente\Services;

use PDOException;
use App\Modules\Cliente\Repositories\ClientesRepository;

class ClientesService
{
    public function create($request)
    {
        try {
            $item = ClientesRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un clientes. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = ClientesRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran clientes.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = ClientesRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra clientes.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = ClientesRepository::update($request);
            if (!$item) {
                throw new \Exception('Clientes inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un clientes. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = ClientesRepository::delete($request);
            if (!$item) {
                throw new \Exception('Clientes inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un clientes. Inténtalo más tarde.');
        }
    }
}
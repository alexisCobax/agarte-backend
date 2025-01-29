<?php

namespace App\Modules\Recibo\Services;

use PDOException;
use App\Modules\Recibo\Repositories\RecibosRepository;

class RecibosService
{
    public function create($request): array
    {
        try {
            $item = RecibosRepository::create($request);

            //$item = recibosDetalleRepository::create($request);

            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un recibos. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = RecibosRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran recibos.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = RecibosRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra recibos.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = RecibosRepository::update($request);
            if (!$item) {
                throw new \Exception('Recibos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un recibos. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = RecibosRepository::delete($request);
            if (!$item) {
                throw new \Exception('Recibos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un recibos. Inténtalo más tarde.');
        }
    }
}
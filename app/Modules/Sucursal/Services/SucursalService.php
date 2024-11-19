<?php

namespace App\Modules\Sucursal\Services;

use PDOException;
use App\Modules\Sucursal\Repositories\SucursalRepository;

class SucursalService
{


    public function create($request): array
    {
        try {
            $sucursal = SucursalRepository::create($request);
            return ["datos" => $sucursal];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear una sucursal. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {

        $sucursales = SucursalRepository::find();

        if (!$sucursales) {
            throw new \Exception('No se encuentran sucursales');
        }
        return $sucursales;
    }

    public function get($request): array
    {

        $sucursales = SucursalRepository::findById($request->getId());

        if (!$sucursales) {
            throw new \Exception('No se encuentra sucursal');
        }
        return $sucursales;
    }

    public function update($request): array
    {
        try {
            $sucursal = SucursalRepository::update($request);
            if (!$sucursal) {
                throw new \Exception('Sucursal inexistente');
            }
            return $sucursal;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar una sucursal. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $sucursal = SucursalRepository::delete($request);
            if (!$sucursal) {
                throw new \Exception('Sucursal inexistente');
            }
            return $sucursal;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar una sucursal. Inténtalo más tarde.');
        }
    }
}

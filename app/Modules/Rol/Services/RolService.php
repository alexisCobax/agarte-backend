<?php

namespace App\Modules\Rol\Services;

use PDOException;
use App\Modules\Rol\Repositories\RolRepository;

class RolService
{


    public function create($request): array
    {
        try {
            $Rol = RolRepository::create($request);
            return ["datos" => $Rol];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un rol. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {

        $Rol = RolRepository::find();

        if (!$Rol) {
            throw new \Exception('No se encuentran rol');
        }
        return $Rol;
    }

    public function get($request): array
    {

        $Rol = RolRepository::findById($request->getId());

        if (!$Rol) {
            throw new \Exception('No se encuentra rol');
        }
        return $Rol;
    }

    public function update($request): array
    {
        try {
            $Rol = RolRepository::update($request);
            if (!$Rol) {
                throw new \Exception('rol inexistente');
            }
            return $Rol;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar una rol. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $Rol = RolRepository::delete($request);
            if (!$Rol) {
                throw new \Exception('rol inexistente');
            }
            return $Rol;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar una Rol. Inténtalo más tarde.');
        }
    }
}

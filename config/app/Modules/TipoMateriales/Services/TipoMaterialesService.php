<?php

namespace App\Modules\TipoMateriales\Services;

use PDOException;
use App\Modules\TipoMateriales\Repositories\TipoMaterialesRepository;

class TipoMaterialesService
{


    public function create($request): array
    {
        try {
            $tipoMaterial = TipoMaterialesRepository::create($request);
            return ["datos" => $tipoMaterial];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un tipo de material. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {

        $tipoMateriales = TipoMaterialesRepository::find();

        if (!$tipoMateriales) {
            throw new \Exception('No se encuentran tipo de materiales');
        }
        return $tipoMateriales;
    }

    public function get($request): array
    {

        $tipoMateriales = TipoMaterialesRepository::findById($request->getId());

        if (!$tipoMateriales) {
            throw new \Exception('No se encuentra tipo de material');
        }
        return $tipoMateriales;
    }

    public function update($request): array
    {
        try {
            $tipoMaterial = TipoMaterialesRepository::update($request);
            if (!$tipoMaterial) {
                throw new \Exception('Tipo de material inexistente');
            }
            return $tipoMaterial;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un tipo de material. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $tipoMaterial = TipoMaterialesRepository::delete($request);
            if (!$tipoMaterial) {
                throw new \Exception('Tipo de material inexistente');
            }
            return $tipoMaterial;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un tipo de material. Inténtalo más tarde.');
        }
    }
}

<?php

namespace App\Modules\TipoEnmarcacion\Services;

use PDOException;
use App\Modules\TipoEnmarcacion\Repositories\TipoEnmarcacionRepository;

class TipoEnmarcacionService
{
    public function create($request): array
    {
        try {
            $tipoEnmarcacion = TipoEnmarcacionRepository::create($request);
            return ["datos" => $tipoEnmarcacion];
        } catch (PDOException $e) {
            echo $e->getMessage();
            throw new \Exception('Error al crear un tipo de enmarcación. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {

        $tipoEnmarcaciones = TipoEnmarcacionRepository::find();

        if (!$tipoEnmarcaciones) {
            throw new \Exception('No se encuentran tipo de enmarcaciónes');
        }
        return $tipoEnmarcaciones;
    }

    public function get($request): array
    {

        $tipoEnmarcaciones = TipoEnmarcacionRepository::findById($request->getId());

        if (!$tipoEnmarcaciones) {
            throw new \Exception('No se encuentra tipo de enmarcación');
        }
        return $tipoEnmarcaciones;
    }

    public function update($request): array
    {
        try {
            $tipoEnmarcacion = TipoEnmarcacionRepository::update($request);
            if (!$tipoEnmarcacion) {
                throw new \Exception('tipo de enmarcación inexistente');
            }
            return $tipoEnmarcacion;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un tipo de enmarcación. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $tipoEnmarcacion = TipoEnmarcacionRepository::delete($request);
            if (!$tipoEnmarcacion) {
                throw new \Exception('tipo de enmarcación inexistente');
            }
            return $tipoEnmarcacion;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar una tipo de enmarcación. Inténtalo más tarde.');
        }
    }
}

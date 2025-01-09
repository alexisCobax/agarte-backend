<?php

namespace App\Modules\ObjetosEnmarcar\Services;

use PDOException;
use App\Modules\ObjetosEnmarcar\Repositories\ObjetosEnmarcarRepository;

class ObjetosEnmarcarService
{
    public function create($request): array
    {
        try {
            $tipoEnmarcacion = ObjetosEnmarcarRepository::create($request);
            return ["datos" => $tipoEnmarcacion];
        } catch (PDOException $e) {
            echo $e->getMessage();
            throw new \Exception('Error al crear un objeto a enmarcar. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {

        $tipoEnmarcaciones = ObjetosEnmarcarRepository::find();

        if (!$tipoEnmarcaciones) {
            throw new \Exception('No se encuentran objeto a enmarcares');
        }
        return $tipoEnmarcaciones;
    }

    public function get($request): array
    {

        $tipoEnmarcaciones = ObjetosEnmarcarRepository::findById($request->getId());

        if (!$tipoEnmarcaciones) {
            throw new \Exception('No se encuentra objeto a enmarcar');
        }
        return $tipoEnmarcaciones;
    }

    public function update($request): array
    {
        try {
            $tipoEnmarcacion = ObjetosEnmarcarRepository::update($request);
            if (!$tipoEnmarcacion) {
                throw new \Exception('objeto a enmarcar inexistente');
            }
            return $tipoEnmarcacion;
        } catch (PDOException $e) {
            echo $e->getMessage();
            throw new \Exception('Error al modificar un objeto a enmarcar. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $tipoEnmarcacion = ObjetosEnmarcarRepository::delete($request);
            if (!$tipoEnmarcacion) {
                throw new \Exception('objeto a enmarcar inexistente');
            }
            return $tipoEnmarcacion;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar una objeto a enmarcar. Inténtalo más tarde.');
        }
    }
}

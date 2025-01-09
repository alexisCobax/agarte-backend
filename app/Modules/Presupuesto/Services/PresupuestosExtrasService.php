<?php

namespace App\Modules\Presupuesto\Services;

use PDOException;
use App\Helpers\LogHelper;
use App\Modules\Presupuesto\Requests\PresupuestosCreateRequest;
use App\Modules\Presupuesto\Repositories\PresupuestosExtrasRepository;

class PresupuestosExtrasService
{
    public function create($request): array
    {
        // try {

        //     $item = PresupuestosExtrasRepository::create($request);
        //     return ["datos" => $item];
        // } catch (PDOException $e) {
        //     //LogHelper::error($e->getMessage());
        //     throw new \Exception('Error al crear un presupuestos Extras. Inténtalo más tarde.');
        // }
        try {

            $idPresupuesto = $request->getIdPresupuesto();

            if ($idPresupuesto == 0) {
                $presupuestoService = new PresupuestosService();
                $createRequest = new PresupuestosCreateRequest;
                $presupuesto = $presupuestoService->create($createRequest);
                $request->setIdPresupuesto($presupuesto['datos']['id']);
            }

            $item = PresupuestosExtrasRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            //LogHelper::error($e->getMessage());
            throw new \Exception('Error al crear un presupuestosdetalle. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = PresupuestosExtrasRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran presupuestos Extras.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = PresupuestosExtrasRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra presupuestos Extras.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = PresupuestosExtrasRepository::update($request);
            if (!$item) {
                throw new \Exception('PresupuestosExtras inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un presupuestos Extras. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = PresupuestosExtrasRepository::delete($request);
            if (!$item) {
                throw new \Exception('Presupuestos Extras inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un presupuestos Extras. Inténtalo más tarde.');
        }
    }
}

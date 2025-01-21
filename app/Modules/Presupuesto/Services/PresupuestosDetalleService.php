<?php

namespace App\Modules\Presupuesto\Services;

use App\Helpers\LogHelper;
use PDOException;
use App\Modules\Presupuesto\Repositories\PresupuestosDetalleRepository;
use App\Modules\Presupuesto\Services\PresupuestosService;
use App\Modules\Presupuesto\Requests\PresupuestosCreateRequest;

class PresupuestosDetalleService
{
    public function create($request): array
    {
        try {
            $idPresupuesto = $request->getIdPresupuesto();

            if ($idPresupuesto == 0) {
                $presupuestoService = new PresupuestosService();
                $createRequest = new PresupuestosCreateRequest;
                $createRequest->setIdSucursal($request->getIdSucursal());

                $presupuesto = $presupuestoService->create($createRequest);
                $request->setIdPresupuesto($presupuesto['datos']['id']);
            }

            $item = PresupuestosDetalleRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            //LogHelper::error($e);
            throw new \Exception('Error al crear un presupuestosdetalle. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = PresupuestosDetalleRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran presupuestosdetalles.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = PresupuestosDetalleRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra presupuestosdetalle.');
        }
        return $item;
    }

    public function update($request): bool
    {
        try {
            $item = PresupuestosDetalleRepository::update($request);
            if (!$item) {
                throw new \Exception('PresupuestosDetalle inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un presupuestosdetalle. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = PresupuestosDetalleRepository::delete($request);
            if (!$item) {
                throw new \Exception('PresupuestosDetalle inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un presupuestosdetalle. Inténtalo más tarde.');
        }
    }

    public function updateObservaciones($request): array
    {
        try {
            $item = PresupuestosDetalleRepository::updateObservaciones($request);
            if (!$item) {
                throw new \Exception('PresupuestosDetalle inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un presupuestosdetalle. Inténtalo más tarde.');
        }
    }

    public function updatePosiciones($request)
    {
        try {
            $item = PresupuestosDetalleRepository::updatePosiciones($request);
            if (!$item) {
                throw new \Exception('PresupuestosDetalle inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un presupuestosdetalle. Inténtalo más tarde.');
        }
    }

}

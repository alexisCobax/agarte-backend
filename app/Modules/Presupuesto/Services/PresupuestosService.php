<?php

namespace App\Modules\Presupuesto\Services;

use PDOException;
use App\Helpers\LogHelper;
use App\Modules\Presupuesto\Repositories\PresupuestosRepository;
use App\Modules\Presupuesto\Repositories\PresupuestosDetalleRepository;

class PresupuestosService
{
    public function create(object $request): array
    {
        try {
            $item = PresupuestosRepository::create($request);
            PresupuestosRepository::calcularCantidades($request->getAlto(), $request->getAncho(), $item['id']);
            return ["datos" => $item];
        } catch (PDOException $e) {
            LogHelper::error($e->getMessage());
            throw new \Exception('Error al crear un presupuestos. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = PresupuestosRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran presupuestos.');
        }
        return $items;
    }

    public function get($request): array
    {
        $presupuesto = PresupuestosRepository::findById($request->getId());
        $presupuestoDetalle = PresupuestosDetalleRepository::findByPresupuestoId($request->getId());

        if (!$presupuesto) {
            throw new \Exception('No se encuentra presupuestos.');
        }
        return ["presupuesto"=>$presupuesto,"detalle"=>$presupuestoDetalle];
    }

    public function update($request): array
    {
        try {
            $item = PresupuestosRepository::update($request);
            if (!$item) {
                throw new \Exception('Presupuestos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            LogHelper::error($e->getMessage());
            throw new \Exception('Error al modificar un presupuestos. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = PresupuestosRepository::delete($request);
            if (!$item) {
                throw new \Exception('Presupuestos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un presupuestos. Inténtalo más tarde.');
        }
    }


    public function calcularTotalPresupuesto($id){
        // $SQL = "SELECT  
        //         SUM(cantidad*precio)
        //         FROM
        //         presupuestos_detalle
        //         WHERE
        //         presupuestos_detalle.id_presupuestos=$id";

        //         $resultado=(response de $SQL) * (1+(tipo_enmarcacion.comision_porcentual/100)) + comision fija
    }
}
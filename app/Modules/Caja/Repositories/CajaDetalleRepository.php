<?php

namespace App\Modules\Caja\Repositories;

use PDO;
use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Modules\Caja\Filters\FindPDFFilter;
use App\Modules\Caja\Filters\FindFilterDetalle;

class CajaDetalleRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                        recibos.id AS id,
                        recibos.numero AS numero,
                        recibos.cliente_nombre as cliente,
                        SUM(CASE WHEN rd.idFormaDePago = 1 THEN rd.monto ELSE 0 END) AS efectivo,
                        SUM(CASE WHEN rd.idFormaDePago = 2 THEN rd.monto ELSE 0 END) AS tarjeta,
                        SUM(CASE WHEN rd.idFormaDePago = 3 THEN rd.monto ELSE 0 END) AS deposito,
                        SUM(rd.monto) AS total,
                        presupuestos.numero_orden AS orden
                    FROM recibos
                        JOIN recibos_detalle rd ON recibos.id = rd.idRecibo 
                        JOIN presupuestos on presupuestos.id = recibos.id_orden_de_trabajo";

            $filters = FindFilterDetalle::getFilters();
            if ($filters) {
                $SQL .= " WHERE " . implode(" AND ", $filters);
            }
            $SQL.="  GROUP BY recibos.id, recibos.numero, recibos.cliente_nombre, presupuestos.numero_orden ";

            $paginator = new PaginatorHelper($connection, $SQL);

            return $paginator->getPaginatedResults();
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la paginación: ' . $e->getMessage());
        }
    }

    public static function findById($request, $id)
    {
        
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                        recibos.id AS id,
                        recibos.numero AS numero,
                        recibos.cliente_nombre as cliente,
                        SUM(CASE WHEN rd.idFormaDePago = 1 THEN rd.monto ELSE 0 END) AS efectivo,
                        SUM(CASE WHEN rd.idFormaDePago = 2 THEN rd.monto ELSE 0 END) AS tarjeta,
                        SUM(CASE WHEN rd.idFormaDePago = 3 THEN rd.monto ELSE 0 END) AS deposito,
                        SUM(rd.monto) AS total,
                        presupuestos.numero_orden AS orden
                    FROM recibos
                        JOIN recibos_detalle rd ON recibos.id = rd.idRecibo 
                        JOIN presupuestos on presupuestos.id = recibos.id_orden_de_trabajo";

            if ($id) {
                $SQL .= " WHERE recibos.id_sucursal =" .$id;
            }

            if ($request->fecha) {
                $SQL .= " AND recibos.fecha =" ."'$request->fecha'";
            }

            $SQL.=" GROUP BY recibos.id, recibos.numero, recibos.cliente_nombre, presupuestos.numero_orden ";

            $paginator = new PaginatorHelper($connection, $SQL);

            return $paginator->getPaginatedResults();
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la paginación: ' . $e->getMessage());
        }
    }

}

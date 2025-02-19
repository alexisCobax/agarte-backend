<?php

namespace App\Modules\OrdenDeTrabajo\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Modules\OrdenDeTrabajo\Filters\FindFilter;
use App\Modules\OrdenDeTrabajo\Filters\FindAllFilter;
use App\Modules\Recibo\Repositories\RecibosRepository;

class OrdenDeTrabajoRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                        presupuestos.id AS id_presupuesto,
                        presupuestos.id_estado AS estado_presupuesto,
                        sucursales.nombre AS nombre_sucursal,
                        DATE_FORMAT(presupuestos.fecha_orden_trabajo, '%d/%m/%Y') AS fecha,
                        presupuestos.cliente_nombre,
                        presupuestos.numero_orden,
                        objetos_a_enmarcar.nombre AS objecto_enmarcar,
                        estados_orden_trabajo.nombre AS estado,
                        DATE_FORMAT(presupuestos.fecha_entrega, '%d/%m/%Y') AS fecha_entrega,
                        COALESCE(recibos.total,0) as pagos,
                        COALESCE(presupuestos.total,0) - COALESCE(recibos.total,0) as saldo,
                        COALESCE(presupuestos.total,0) AS total
                    FROM 
                        presupuestos
                            LEFT JOIN sucursales ON presupuestos.id_sucursal = sucursales.id
                            LEFT JOIN objetos_a_enmarcar ON presupuestos.id_objeto_a_enmarcar=objetos_a_enmarcar.id
                            LEFT JOIN estados_orden_trabajo ON presupuestos.estado_orden_trabajo=estados_orden_trabajo.id
                            LEFT JOIN (SELECT `id_orden_de_trabajo`, sum(`total`) as total FROM `recibos` where `suspendido` = 0 group by `id_orden_de_trabajo`  ) as recibos ON recibos.id_orden_de_trabajo = presupuestos.id
                    WHERE
                        presupuestos.id_estado IN (3, 4) ";

            $filters = FindFilter::getFilters();
            if ($filters) {
                $SQL .= " AND " . implode(" AND ", $filters);
            }

            $SQL .= " ORDER BY presupuestos.numero_orden DESC";

            $paginator = new PaginatorHelper($connection, $SQL);

            return $paginator->getPaginatedResults();
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la paginación: ' . $e->getMessage());
        }
    }

    public static function findAll()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                        presupuestos.id AS id_presupuesto,
                        presupuestos.id_estado AS estado_presupuesto,
                        sucursales.nombre AS nombre_sucursal,
                        DATE_FORMAT(presupuestos.fecha_orden_trabajo, '%d/%m/%Y') AS fecha,
                        presupuestos.cliente_nombre,
                        presupuestos.numero_orden,
                        objetos_a_enmarcar.nombre AS objecto_enmarcar,
                        estados_orden_trabajo.nombre AS estado,
                        DATE_FORMAT(presupuestos.fecha_entrega, '%d/%m/%Y') AS fecha_entrega,
                        COALESCE(recibos.total,0) as pagos,
                        COALESCE(presupuestos.total,0) - COALESCE(recibos.total,0) as saldo,
                        COALESCE(presupuestos.total,0) AS total
                    FROM 
                        presupuestos
                            LEFT JOIN sucursales ON presupuestos.id_sucursal = sucursales.id
                            LEFT JOIN objetos_a_enmarcar ON presupuestos.id_objeto_a_enmarcar=objetos_a_enmarcar.id
                            LEFT JOIN estados_orden_trabajo ON presupuestos.estado_orden_trabajo=estados_orden_trabajo.id
                            LEFT JOIN (SELECT `id_orden_de_trabajo`, sum(`total`) as total FROM `recibos` where `suspendido` = 0 group by `id_orden_de_trabajo`  ) as recibos ON recibos.id_orden_de_trabajo = presupuestos.id
                    WHERE
                        presupuestos.id_estado=3";

            $filters = FindAllFilter::getFilters();
            if ($filters) {
                $SQL .= " AND " . implode(" AND ", $filters);
            }

            $SQL .= " ORDER BY presupuestos.numero_orden DESC";

            $paginator = new PaginatorHelper($connection, $SQL);

            return $paginator->getPaginatedResults();
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la paginación: ' . $e->getMessage());
        }
    }

    public static function findById(int $id)
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT * FROM orden_de_trabajo WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function findLastNumber(int $id_sucursal): int
    {

        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT numero_orden FROM presupuestos WHERE id_sucursal = ? ORDER BY numero_orden DESC LIMIT 1");
            $stmt->execute([$id_sucursal]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['numero_orden'] ?? 0;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function create($request): int
    {
        try {
            $connection = Database::getConnection();
            $SQL = "UPDATE presupuestos 
                SET 
                id_estado = ?,
                numero_orden = ?
                WHERE 
                id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                3,
                self::findLastNumber($request->getIdSucursal()) + 1,
                $request->getId()
            ]);
            return $request->getId();
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function update($request): bool
    {
        try {
            $connection = Database::getConnection();
            try {
                $connection = Database::getConnection();
                $SQL = "UPDATE 
                presupuestos 
                SET 
                id_estado = ?,
                comentarios = ? 
                WHERE 
                id = ?";
                $stmt = $connection->prepare($SQL);
                $stmt->execute([$request->fecha_entrega, $request->comentarios]);
                return true;
            } catch (PDOException $e) {
                LogHelper::error($e);
                throw new \Exception('Error: ' . $e->getMessage());
            }
            return true;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function updateStatus($request, $id): bool
    {

        $idPresupuesto = $id === null ? $request->id : $id;

        try {
            $connection = Database::getConnection();
            $SQL = "UPDATE 
            presupuestos 
            SET 
            id_estado = ?,
            comentarios_taller = ? 
            WHERE 
            id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$request->id_estado, $request->comentarios, $idPresupuesto]);
            return true;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function delete(int $id): bool
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("DELETE FROM orden_de_trabajo WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function actualizarOrden($request): bool
    {
        try {
            $connection = Database::getConnection();
            $SQL = "UPDATE 
            presupuestos 
            SET 
            fecha_entrega = ?,
            comentarios = ? 
            WHERE 
            id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$request->fecha_entrega, $request->comentarios, $request->id_presupuesto]);
            return true;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }
}

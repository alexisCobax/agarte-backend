<?php

namespace App\Modules\OrdenDeTrabajo\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Modules\OrdenDeTrabajo\Filters\FindFilter;
use App\Modules\Recibo\Repositories\RecibosRepository;

class OrdenDeTrabajoRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                        presupuestos.id AS id_presupuesto,
                        presupuestos.id_estado,
                        sucursales.nombre AS nombre_sucursal,
                        DATE_FORMAT(presupuestos.fecha, '%d/%m/%Y') AS fecha,
                        presupuestos.cliente_nombre,
                        presupuestos.numero_orden,
                        objetos_a_enmarcar.nombre AS objecto_enmarcar,
                        estados_orden_trabajo.nombre AS estado,
                        COALESCE(recibos.total,0) as pagos,
                        COALESCE(presupuestos.total,0) - COALESCE(recibos.total,0) as saldo,
                        COALESCE(presupuestos.total,0) AS total
                    FROM 
                        presupuestos
                            LEFT JOIN sucursales ON presupuestos.id_sucursal = sucursales.id
                            LEFT JOIN objetos_a_enmarcar ON presupuestos.id_objeto_a_enmarcar=objetos_a_enmarcar.id
                            LEFT JOIN estados_orden_trabajo ON presupuestos.id_estado=estados_orden_trabajo.id
                            LEFT JOIN (SELECT `id_orden_de_trabajo`, sum(`total`) as total FROM `recibos` where `suspendido` = 0 group by `id_orden_de_trabajo`  ) as recibos ON recibos.id_orden_de_trabajo = presupuestos.id
                    WHERE
                        presupuestos.id_estado=3";

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

    public static function generar($request)
    {

        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT * FROM presupuestos WHERE id = ?");
            $stmt->execute([$request->id_presupuesto]);
            $datosPresupuesto = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }


        $connection = Database::getConnection();


        $numeroOrden = OrdenDeTrabajoRepository::findLastNumber($datosPresupuesto['id_sucursal']) + 1;

        try {
            $connection = Database::getConnection();
            $SQL = "UPDATE presupuestos 
                            SET 
                            id_estado = ?,
                            fecha_entrega = ?,
                            reserva = ?,
                            numero_orden = ?
                            WHERE 
                            id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                3, // TIPO ORDEN
                $request->fecha_entrega,
                $request->reserva,
                $numeroOrden,
                $request->id_presupuesto
            ]);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }

        $numeroRecibo = RecibosRepository::findLastNumber($datosPresupuesto['id_sucursal']) + 1;

        try {
            $SQL = "INSERT INTO 
                    recibos 
                    (id_cliente, 
                    cliente_nombre,
                    cliente_email, 
                    cliente_domicilio,
                    cliente_telefono,
                    fecha,
                    total,
                    id_orden_de_trabajo,
                    id_forma_de_pago,
                    suspendido,
                    cargado_por,
                    numero,
                    id_sucursal) 
                    VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datosPresupuesto['id_cliente'],
                $datosPresupuesto['cliente_nombre'],
                $datosPresupuesto['cliente_email'],
                $datosPresupuesto['cliente_domicilio'],
                $datosPresupuesto['cliente_telefono'],
                $datosPresupuesto['fecha'],
                $datosPresupuesto['total'],
                $request->id_presupuesto,
                0, // ID FORMA DE PAGO 0 POR DEFAULT
                0, // SUSPENDIDO 0 POR DEFAULT
                $datosPresupuesto['creado_por'],
                $numeroRecibo,
                $datosPresupuesto['id_sucursal']
            ]);

            $connection = Database::getConnection();

            $id = $connection->lastInsertId();
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }

        try {
            $SQL = "INSERT INTO 
                    recibos_detalle 
                    (idRecibo, 
                    idFormaDePago,
                    monto,
                    observaciones) 
                    VALUES 
                    (?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $id,
                $request->forma_pago,
                $request->reserva,
                ''
            ]);

            return $datosPresupuesto;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function update(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la actualización en la tabla orden_de_trabajo
            return true;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
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
}

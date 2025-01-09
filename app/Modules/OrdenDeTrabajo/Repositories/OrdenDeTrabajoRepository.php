<?php

namespace App\Modules\OrdenDeTrabajo\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;

class OrdenDeTrabajoRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT
                    orden_de_trabajo.id,
                    DATE_FORMAT(orden_de_trabajo.fecha, '%d/%m/%Y') AS fecha,
                    orden_de_trabajo.id_cliente,
                    orden_de_trabajo.id_estado,
                    orden_de_trabajo.total,
                    orden_de_trabajo.id_empleado,
                    orden_de_trabajo.id_tipo_enmarcacion,
                    orden_de_trabajo.id_tipo_vidrio,
                    orden_de_trabajo.comentarios,
                    DATE_FORMAT(orden_de_trabajo.fecha_estipulada, '%d/%m/%Y') AS fecha_estipulada,
                    orden_de_trabajo.reserva,
                    DATE_FORMAT(orden_de_trabajo.fecha_entrega, '%d/%m/%Y') AS fecha_entrega,
                    clientes.nombre AS cliente_nombre,
                    empleados.nombre AS empleado_nombre,
                    tipo_enmarcacion.nombre AS tipo_enmarcacion_nombre
                    FROM 
                    orden_de_trabajo
                    LEFT JOIN
                    clientes
                    ON
                    orden_de_trabajo.id_cliente=clientes.id
                    LEFT JOIN 
                    empleados 
                    ON
                    orden_de_trabajo.id_empleado=empleados.id
                    LEFT JOIN 
                    tipo_enmarcacion
                    ON
                    orden_de_trabajo.id_tipo_enmarcacion=tipo_enmarcacion.id";

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

    public static function create(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la inserción en la tabla orden_de_trabajo
            return true;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la base de datos: ' . $e->getMessage());
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

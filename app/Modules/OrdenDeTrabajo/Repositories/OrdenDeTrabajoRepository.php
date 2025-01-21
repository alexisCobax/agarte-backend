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
                    presupuestos.id AS id_presupuesto,
                    presupuestos.id_estado,
                    sucursales.nombre AS nombre_sucursal,
                    DATE_FORMAT(presupuestos.fecha, '%d/%m/%Y') AS fecha,
                    presupuestos.cliente_nombre,
                    presupuestos.numero_orden,
                    objetos_a_enmarcar.nombre AS objecto_enmarcar,
                    estados_orden_trabajo.nombre AS estado
                    FROM 
                        presupuestos
                    LEFT JOIN sucursales
                        ON presupuestos.id_sucursal = sucursales.id
                    LEFT JOIN
                        objetos_a_enmarcar
                        ON
                        presupuestos.id_objeto_a_enmarcar=objetos_a_enmarcar.id
                        LEFT JOIN
                        estados_orden_trabajo
                        ON
                        presupuestos.id_estado=estados_orden_trabajo.id
                    WHERE
                        presupuestos.id_estado=3";
                        

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

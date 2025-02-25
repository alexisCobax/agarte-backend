<?php

namespace App\Modules\Caja\Repositories;

use PDO;
use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Modules\Caja\Filters\FindFilter;

class CajaRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                    empleados.id,
                    empleados.nombre,
                    empleados.email,
                    empleados.telefono,
                    empleados.id_sucursal,
                    empleados.id_usuario,
                    sucursales.id AS sucursal_id,
                    sucursales.nombre AS nombre_sucursal
                    FROM 
                    empleados 
                     INNER JOIN 
                        sucursales 
                    ON 
                    empleados.id_sucursal=sucursales.id";

            $filters = FindFilter::getFilters();
            if ($filters) {
                $SQL .= " WHERE " . implode(" AND ", $filters);
            }

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
            $SQL = "SELECT
                    empleados.id,
                    empleados.nombre,
                    empleados.email,
                    empleados.telefono,
                    empleados.id_sucursal,
                    empleados.id_usuario,
                    usuarios.usuario,
                    usuarios.rol
                    FROM
                    empleados
                    LEFT JOIN
                    usuarios
                    ON
                    empleados.id_usuario=usuarios.id
                    WHERE
                    empleados.id=?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function findBySucursalId(int $id)
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT
                    recibos.id AS idRecibo,
                    recibos.cliente_nombre,
                    recibos.cliente_email,
                    recibos.cliente_domicilio,
                    recibos.cliente_telefono,
                    sucursales.nombre AS nombreSucursal
                    FROM
                    recibos
                    INNER JOIN
                    sucursales
                    ON
                    recibos.id_sucursal=sucursales.id
                    WHERE
                    id_sucursal=?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function create(object $datos): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "INSERT INTO 
            empleados
            (nombre,
            email, 
            telefono, 
            id_sucursal, 
            id_usuario,
            suspendido, 
            fecha_alta, 
            creado_por, 
            modificado_por, 
            fecha_baja) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getEmail(),
                $datos->getTelefono(),
                $datos->getIdSucursal(),
                $datos->getIdUsuario(),
                $datos->getSuspendido(),
                $datos->getFechaAlta(),
                $datos->getCreadoPor(),
                $datos->getModificadoPor(),
                date('Y-m-d H:i:s')
            ]);

            $id = $connection->lastInsertId();

            return self::findById($id);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public static function update(object $datos): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "UPDATE empleados 
            SET 
            nombre = ?,
            email = ?, 
            telefono = ?, 
            id_sucursal = ?, 
            id_usuario = ?,
            suspendido = ?, 
            creado_por = ?, 
            modificado_por = ?, 
            fecha_baja = ?
            WHERE 
            id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getEmail(),
                $datos->getTelefono(),
                $datos->getIdSucursal(),
                $datos->getIdUsuario(),
                $datos->getSuspendido(),
                $datos->getCreadoPor(),
                $datos->getModificadoPor(),
                $datos->getFechaBaja(),
                $datos->getId()
            ]);
            return self::findById($datos->getId());
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function delete(int $id): bool
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("DELETE FROM empleados WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
}

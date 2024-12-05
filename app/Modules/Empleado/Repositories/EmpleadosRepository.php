<?php

namespace App\Modules\Empleado\Repositories;

use PDO;
use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Exceptions\DatabaseException;
use App\Modules\Empleado\Filters\FindFilter;

class EmpleadosRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                    empleados.id,
                    empleados.nombre,
                    empleados.apellido,
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
        } catch (\Exception $e) {
            LogHelper::error('Database: ' . $e->getMessage());
            throw new DatabaseException('Error en la paginación: ' . $e->getMessage());
        }
    }

    public static function findById(int $id)
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT * FROM empleados WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function create(object $datos): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "INSERT INTO 
            empleados
            (nombre, 
            apellido, 
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
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getApellido(),
                $datos->getEmail(),
                $datos->getTelefono(),
                $datos->getIdSucursal(),
                $datos->getIdUsuario(),
                $datos->getSuspendido(),
                $datos->getFechaAlta(),
                $datos->getCreadoPor(),
                $datos->getModificadoPor(),
                $datos->getFechaBaja()
            ]);

            $id = $connection->lastInsertId();

            return self::findById($id);
        } catch (PDOException $e) {
            LogHelper::error('Database: ' . $e->getMessage());
            throw new \Exception('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public static function update(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la actualización en la tabla empleados
            return true;
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
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
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }
}

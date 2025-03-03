<?php

namespace App\Modules\Sucursal\Repositories;

use App\Config\Database;
use App\Helpers\PaginatorHelper;
use App\Modules\Sucursal\Filters\FindFilter;
use App\Helpers\LogHelper;
use PDOException;

class SucursalRepository
{

    public static function find(): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM sucursales";

            $filters = FindFilter::getFilters();
            if ($filters) {
                $SQL .= " WHERE " . implode(" AND ", $filters);
            }

            $paginator = new PaginatorHelper($connection, $SQL);

            return $paginator->getPaginatedResults();

        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la base de datos: ' . $e->getMessage());
        }
    }


    public static function findById(int $id): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                    * 
                    FROM 
                    sucursales 
                    WHERE 
                    id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }

            return [];
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public static function create(object $datos): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "INSERT INTO 
                    sucursales 
                    (nombre, logo, domicilio, telefono) 
                    VALUES 
                    (?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getLogo(),
                $datos->getDomicilio(),
                $datos->getTelefono()
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
            $SQL = "UPDATE sucursales 
                    SET 
                    nombre = ?, 
                    logo = ?, 
                    domicilio = ?, 
                    telefono = ? 
                    WHERE 
                    id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getLogo(),
                $datos->getDomicilio(),
                $datos->getTelefono(),
                $datos->getId()
            ]);

            return self::findById($datos->getId());

        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la base de datos: ' . $e->getMessage());
        }
    }
}

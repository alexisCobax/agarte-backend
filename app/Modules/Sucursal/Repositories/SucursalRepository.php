<?php

namespace App\Modules\Sucursal\Repositories;

use App\Config\Database;
use App\Helpers\PaginatorHelper;
use App\Modules\Sucursal\Filters\FindFilter;
use App\Exceptions\DatabaseException;
use App\Helpers\LogHelper;

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

            $resultados = $paginator->getPaginatedResults();

            if ((isset($resultados['results']) && empty($resultados['results'])) || empty($resultados)) {
                throw new \Exception('No se encuentran sucursales');
            }

            return $resultados;
        } catch (\Exception $e) {
            LogHelper::error('Database: '.$e->getMessage());
            throw new DatabaseException('Error en la paginación: ' . $e->getMessage());
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
        } catch (DatabaseException $e) {
            LogHelper::error('Database: '.$e->getMessage());
            throw new DatabaseException('Error: ' . $e->getMessage());
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

            $query = "SELECT 
                      * 
                      FROM 
                      sucursales 
                      WHERE 
                      id = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (DatabaseException $e) {
            LogHelper::error('Database: '.$e->getMessage());
            throw new DatabaseException('Error en la base de datos: ' . $e->getMessage());
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

            $SQL = "SELECT 
                    * 
                    FROM 
                    sucursales 
                    WHERE 
                    id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$datos->getId()]);

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }

            return [];
        } catch (DatabaseException $e) {
            LogHelper::error('Database: '.$e->getMessage());
            throw new DatabaseException('Error: ' . $e->getMessage());
        }
    }


    public static function delete(object $datos): bool
    {
        try {
            $connection = Database::getConnection();
            $SQL = "DELETE 
                    FROM 
                    sucursales 
                    WHERE 
                    id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$datos->getId()]);
            if (!$stmt->rowCount() > 0) {
                return false;
            }
        } catch (DatabaseException $e) {
            LogHelper::error('Database: '.$e->getMessage());
            throw new DatabaseException('Error: ' . $e->getMessage());
        }
    }
}

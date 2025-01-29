<?php

namespace App\Modules\FormaDePago\Repositories;

use App\Config\Database;
use App\Helpers\PaginatorHelper;
use App\Modules\FormaDePago\Filters\FindFilter;
use App\Helpers\LogHelper;
use PDOException;

class FormaDePagoRepository
{

    public static function find(): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM forma_de_pago";

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


    public static function findById(int $id): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                    * 
                    FROM 
                    forma_de_pago 
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
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function create(object $datos): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "INSERT INTO 
                    forma_de_pago 
                    (nombre, suspendido) 
                    VALUES 
                    (?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getSuspendido()
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
            $SQL = "UPDATE forma_de_pago 
                    SET 
                    nombre = ?, 
                    suspendido = ?
                   
                    WHERE 
                    id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getSuspendido(),
                $datos->getId()
            ]);

            return self::findById($datos->getId());

        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }


    public static function delete(object $datos): bool
    {
        try {
            $connection = Database::getConnection();
            $SQL = "UPDATE                      
                    forma_de_pàgo 
                    SET suspendido=1
                    WHERE 
                    id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$datos->getId()]);
            if (!$stmt->rowCount() > 0) {
                return false;
            }
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
}

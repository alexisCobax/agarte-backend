<?php

namespace App\Modules\TipoEnmarcacion\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Modules\TipoEnmarcacion\Filters\FindFilter;

class TipoEnmarcacionRepository
{
    public static function find(): array 
    { 
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM tipo_enmarcacion";

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
                    tipo_enmarcacion
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
                    tipo_enmarcacion  
                    (nombre, comisionFija, comisionPorcentual, suspendida, id_sucursal) 
                    VALUES 
                    (?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getComisionFija(),
                $datos->getComisionPorcentual(),
                $datos->getSuspendido(),
                $datos->getIdSucursal()
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
            $SQL = "UPDATE tipo_enmarcacion  
                    SET 
                    nombre = ?, 
                    comisionFija = ?, 
                    comisionPorcentual = ?, 
                    suspendida = ?,
                    id_sucursal = ?
                    WHERE 
                    id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getComisionFija(),
                $datos->getComisionPorcentual(),
                $datos->getSuspendido(),
                $datos->getIdSucursal(),
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
                    tipo_enmarcacion
                    SET
                    borrado=1 
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

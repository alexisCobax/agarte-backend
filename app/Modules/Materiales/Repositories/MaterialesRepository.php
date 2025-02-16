<?php

namespace App\Modules\Materiales\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Modules\Materiales\Filters\FindFilter;

class MaterialesRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                    materiales.id,
                    materiales.nombre AS nombreMaterial,
                    materiales.precio,
                    tipo_material.nombre AS nombreTipoMaterial
                    FROM 
                    materiales
                    LEFT JOIN 
                    tipo_material
                    ON
                    materiales.id_tipo_material=tipo_material.id";

            $filters = FindFilter::getFilters();
            if ($filters) {
                $SQL .= " WHERE " . implode(" AND ", $filters);
            }

            $SQL .= " ORDER BY materiales.nombre ASC";

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
            $stmt = $connection->prepare("SELECT * FROM materiales WHERE id = ?");
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
                    materiales 
                    (id_tipo_material, 
                    nombre,
                    precio) 
                    VALUES 
                    (?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getIdTipoMaterial(),
                $datos->getNombre(),
                $datos->getPrecio()
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
            $SQL = "UPDATE 
            materiales
            SET 
            id_tipo_material = ?, 
            nombre = ?,
            precio = ?
            WHERE 
            id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getIdTipoMaterial(),
                $datos->getNombre(),
                $datos->getPrecio(),
                $datos->getId()
            ]);

            return self::findById($datos->getId());
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function delete($request): bool
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("UPDATE materiales SET borrado = 1 WHERE id=?");
            $stmt->execute([$request->getId()]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
}

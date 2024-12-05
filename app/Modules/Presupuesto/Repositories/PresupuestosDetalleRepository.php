<?php

namespace App\Modules\Presupuesto\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Exceptions\DatabaseException;
use App\Modules\Presupuesto\Filters\FindFilter;

class PresupuestosDetalleRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                    presupuestos_detalle.id,
                    presupuestos_detalle.id_presupuesto, 
                    tipo_material.nombre as nombre_material,
                    presupuestos_detalle.cantidad, 
                    presupuestos_detalle.posicion, 
                    presupuestos_detalle.observaciones,
                    presupuestos_detalle.precio
                    FROM 
                    presupuestos_detalle
                    LEFT JOIN  
                    tipo_material
                    ON
                    presupuestos_detalle.id_material=tipo_material.id";

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
            $stmt = $connection->prepare("SELECT * FROM presupuestos_detalle WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function findByPresupuestoId(int $id)
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT * FROM presupuestos_detalle WHERE id_presupuesto = ?");
            $stmt->execute([$id]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function create(object $datos): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "INSERT INTO 
                    presupuestos_detalle 
                    (id_presupuesto, 
                    id_material,
                    cantidad, 
                    posicion,
                    precio_unitario,
                    observaciones) 
                    VALUES 
                    (?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getIdPresupuesto(),
                $datos->getIdMaterial(),
                $datos->getCantidad(),
                $datos->getPosicion(),
                $datos->getPrecio(),
                $datos->getObservaciones()
            ]);

            $id = $connection->lastInsertId();

            return self::findById($id);
        } catch (DatabaseException $e) {
            LogHelper::error('Database: ' . $e->getMessage());
            throw new DatabaseException('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public static function update(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la actualización en la tabla presupuestos_detalle
            return true;
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function delete(int $id): bool
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("DELETE FROM presupuestos_detalle WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }
}

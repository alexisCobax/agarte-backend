<?php

namespace App\Modules\Presupuesto\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
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
                    materiales.nombre as nombre_material,
                    presupuestos_detalle.cantidad, 
                    presupuestos_detalle.posicion, 
                    presupuestos_detalle.observaciones,
                    presupuestos_detalle.precio_unitario, 
                    materiales.id_tipo_material
                    FROM 
                    presupuestos_detalle
                    LEFT JOIN  
                    materiales
                    ON
                    presupuestos_detalle.id_material=materiales.id";

            $filters = FindFilter::getFilters();
            if ($filters) {
                $SQL .= " WHERE " . implode(" AND ", $filters);
            }

            $SQL .= " ORDER BY presupuestos_detalle.posicion ASC";

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
            $stmt = $connection->prepare("SELECT * FROM presupuestos_detalle WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
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
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
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
                $datos->getPrecioUnitario(),
                $datos->getObservaciones()
            ]);

            $id = $connection->lastInsertId();

            $SQL = "UPDATE 
                        presupuestos_detalle 
                            LEFT JOIN materiales ON presupuestos_detalle.id_material=materiales.id
                    SET presupuestos_detalle.precio_unitario = materiales.precio 
                    WHERE presupuestos_detalle.id= ? ";

            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id]);

            return self::findById($id);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public static function update(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la actualización en la tabla presupuestos_detalle
            return true;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function updateObservaciones(object $datos): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "UPDATE 
                        presupuestos_detalle 
                    SET  observaciones = ? 
                    WHERE  id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getObservaciones(),
                $datos->getId()
            ]);
            return self::findById($datos->getId());
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function updatePosiciones(object $datos): array
    {

        $posiciones = $datos->getPosiciones();

        try {
            foreach ($posiciones as $index => $id) {
                $posicion = $index + 1;
                $connection = Database::getConnection();
                $SQL = "UPDATE 
                            presupuestos_detalle 
                        SET posicion = ? 
                        WHERE id = ?";
                $stmt = $connection->prepare($SQL);
                $stmt->execute([
                    $posicion,
                    $id
                ]);
            }

            return self::getIdByPosiciones($posiciones);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function getIdByPosiciones(array $posiciones): array
    {
        try {
            $placeholders = implode(",", array_map('intval', $posiciones));

            $connection = Database::getConnection();

            $SQL = "SELECT 
                        id, 
                        posicion 
                    FROM 
                        presupuestos_detalle 
                    WHERE 
                        id IN ($placeholders) ORDER BY posicion ASC";
            $stmt = $connection->prepare($SQL);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function delete(object $datos): bool
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("DELETE FROM presupuestos_detalle WHERE id = ?");
            $stmt->execute([$datos->getId()]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
}

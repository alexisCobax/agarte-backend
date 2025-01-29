<?php

namespace App\Modules\Presupuesto\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;

class PresupuestosExtrasRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                    presupuestos_extras.id,
                    presupuestos_extras.id_presupuesto, 
                    presupuestos_extras.descripcion, 
                    presupuestos_extras.cantidad, 
                    presupuestos_extras.precio_unitario
                    FROM 
                        presupuestos_extras ";

            $SQL .= " WHERE presupuestos_extras.id_presupuesto=".$_GET['id_presupuesto']."";

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
            $stmt = $connection->prepare("SELECT * FROM presupuestos_extras WHERE id = ?");
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
            $stmt = $connection->prepare("SELECT * FROM presupuestos_extras WHERE id_presupuesto = ?");
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
                    presupuestos_extras 
                    (id_presupuesto, 
                    descripcion,
                    cantidad, 
                    precio_unitario) 
                    VALUES 
                    (?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getIdPresupuesto(),
                $datos->getDescripcion(),
                $datos->getCantidad(),
                $datos->getPrecioUnitario()
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
            presupuestos_extras 
            SET 
            descripcion = ?,
            cantidad = ? ,
            precio_unitario = ?  
            WHERE 
            id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getDescripcion(),
                $datos->getCantidad(),
                $datos->getPrecioUnitario(),
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
            $stmt = $connection->prepare("DELETE FROM presupuestos_extras WHERE id = ?");
            $stmt->execute([$datos->getId()]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
}

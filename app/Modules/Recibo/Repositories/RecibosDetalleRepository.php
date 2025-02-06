<?php

namespace App\Modules\Recibo\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;

class RecibosDetalleRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM recibos";

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
            $stmt = $connection->prepare("SELECT * FROM recibos_detalle WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function findByReciboId(int $id)
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                    recibos_detalle.idRecibo,
                    recibos_detalle.idFormaDePago,
                    recibos_detalle.monto,
                    recibos_detalle.observaciones,
                    forma_de_pago.id,
                    forma_de_pago.nombre AS formaPagoNombre
                    FROM 
                    recibos_detalle 
                    INNER JOIN
                    forma_de_pago
                    ON 
                    recibos_detalle.idFormaDePago=forma_de_pago.id
                    WHERE 
                    recibos_detalle.idRecibo = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function create(object $datos): bool
    {
        try {
            $connection = Database::getConnection();

            $SQL = "INSERT INTO 
                    recibos_detalle 
                    (   `idRecibo`, 
                        `idFormaDePago`, 
                        `monto`,
                        observaciones ) 
                    VALUES 
                    (?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos['idRecibo'],
                $datos['idFormaDePago'],
                $datos['monto'],
                $datos['observaciones']
            ]);
            $id = $connection->lastInsertId();

           

            return self::findById($id);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function update(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la actualización en la tabla recibos
            return true;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function delete(int $id): bool
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("DELETE FROM recibos_detalle WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Modules\Orden\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Exceptions\DatabaseException;

class EstadosOrdenTrabajoRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM estados_orden_trabajo";

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
            $stmt = $connection->prepare("SELECT * FROM estados_orden_trabajo WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function create(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la inserción en la tabla estados_orden_trabajo
            return true;
        } catch (PDOException $e) {
            throw new \Exception('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public static function update(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la actualización en la tabla estados_orden_trabajo
            return true;
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function delete(int $id): bool
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("DELETE FROM estados_orden_trabajo WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }
}

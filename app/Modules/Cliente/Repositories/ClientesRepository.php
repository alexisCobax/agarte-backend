<?php

namespace App\Modules\Cliente\Repositories;

use App\Config\Database;
use PDOException;

class ClientesRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT * FROM clientes");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function findById(int $id)
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT * FROM clientes WHERE id = ?");
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
            // Implementar la inserción en la tabla clientes
            return true;
        } catch (PDOException $e) {
            throw new \Exception('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public static function update(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la actualización en la tabla clientes
            return true;
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function delete(int $id): bool
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("DELETE FROM clientes WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }
}
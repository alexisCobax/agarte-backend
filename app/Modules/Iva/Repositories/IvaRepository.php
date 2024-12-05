<?php

namespace App\Modules\Iva\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Exceptions\DatabaseException;

class IvaRepository
{

    public static function find(): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM condiciones_iva";

            $paginator = new PaginatorHelper($connection, $SQL);
            
            return $paginator->getPaginatedResults();

        } catch (\Exception $e) {
            LogHelper::error('Database: ' . $e->getMessage());
            throw new DatabaseException('Error en la paginación: ' . $e->getMessage());
        }
    }

    public static function findById(int $id)
    {
        //--
    }

    public static function create(array $datos)
    {
        //--
    }

    public static function update(array $datos)
    {
        //--
    }

    public static function delete(int $id)
    {
        //--
    }
}

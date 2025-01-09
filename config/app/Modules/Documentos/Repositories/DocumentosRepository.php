<?php

namespace App\Modules\Documentos\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;

class DocumentosRepository
{

    public static function find(): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM tipo_documento";

            $paginator = new PaginatorHelper($connection, $SQL);

            return $paginator->getPaginatedResults();
            
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la paginación: ' . $e->getMessage());
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

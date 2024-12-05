<?php

namespace App\Modules\TipoEnmarcacion\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Exceptions\DatabaseException;

class TipoEnmarcacionRepository
{
    public static function find(): array 
    { 
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM tipo_enmarcacion";

            $paginator = new PaginatorHelper($connection, $SQL);

            return $paginator->getPaginatedResults();

        } catch (\Exception $e) {
            LogHelper::error('Database: '.$e->getMessage());
            throw new DatabaseException('Error en la paginación: ' . $e->getMessage());
        }
    }
    public static function findById(): array { return []; }
    public static function create(): array { return []; }
    public static function update(): array { return []; }
    public static function delete(): bool { return true; }
}

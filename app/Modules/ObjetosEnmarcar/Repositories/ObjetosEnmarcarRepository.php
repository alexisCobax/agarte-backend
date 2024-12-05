<?php

namespace App\Modules\ObjetosEnmarcar\Repositories;

use App\Config\Database;
use App\Helpers\PaginatorHelper;
use App\Modules\Sucursal\Filters\FindFilter;
use App\Exceptions\DatabaseException;
use App\Helpers\LogHelper;

class ObjetosEnmarcarRepository
{
    public static function find(): array 
    {  
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM objetos_a_enmarcar";

            $filters = FindFilter::getFilters();
            if ($filters) {
                $SQL .= " WHERE " . implode(" AND ", $filters);
            }

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

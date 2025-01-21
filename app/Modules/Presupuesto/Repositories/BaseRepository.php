<?php

namespace App\Modules\Presupuesto\Repositories;

use App\Config\Database;
use PDO;
use PDOException;

abstract class BaseRepository
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    /**
     * Actualización dinámica de registros en cualquier tabla
     * 
     * @param string $table
     * @param array $data
     * @param string $primaryKey
     * @param mixed $primaryValue
     * @return bool
     * @throws PDOException
     */
    public function updateData(string $table, array $data, string $primaryKey, $primaryValue): bool
    {
        $setClauses = [];
        $values = [];

        // Construcción dinámica de las columnas a actualizar
        foreach ($data as $column => $value) {
            if ($value !== null) { // Ignorar columnas nulas
                $setClauses[] = "$column = ?";
                $values[] = $value;
            }
        }

        // Verificar que haya campos para actualizar
        if (empty($setClauses)) {
            throw new \InvalidArgumentException("No hay campos para actualizar en la tabla $table.");
        }

        // Agregar la cláusula WHERE
        $values[] = $primaryValue;
        $sql = "UPDATE $table SET " . implode(", ", $setClauses) . " WHERE $primaryKey = ?";

        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            throw new PDOException("Error al ejecutar la consulta: " . $e->getMessage());
        }
    }
}

<?php

namespace App\Modules\Cliente\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Modules\Cliente\Filters\FindFilter;

class ClientesRepository
{

    public static function find(): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT * FROM clientes";

            $filters = FindFilter::getFilters();
            if ($filters) {
                $SQL .= " WHERE " . implode(" AND ", $filters);
            }

            $paginator = new PaginatorHelper($connection, $SQL);

            return $paginator->getPaginatedResults();

        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error en la paginación: ' . $e->getMessage());
        }
    }

    public static function findById(int $id): array
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT * FROM clientes WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
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
            clientes
            (nombre, 
            domicilio,
            id_localidad, 
            email, 
            telefono, 
            id_tipo_documento, 
            documento, 
            id_condicion_iva, 
            descuento,
            fecha_alta, 
            creado_por, 
            modificado_por, 
            fecha_baja) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getDomicilio(),
                $datos->getIdLocalidad(),
                $datos->getEmail(),
                $datos->getTelefono(),
                $datos->getIdTipoDocumento(),
                $datos->getDocumento(),
                $datos->getIdCondicionIva(),
                $datos->getDescuento(),
                $datos->getFechaAlta(),
                $datos->getCreadoPor(),
                $datos->getModificadoPor(),
                $datos->getFechaBaja()
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
            $SQL = "UPDATE clientes 
            SET 
            nombre = ?, 
            domicilio = ?, 
            id_localidad = ?, 
            email = ?, 
            telefono = ?, 
            id_tipo_documento = ?, 
            documento = ?, 
            id_condicion_iva = ?, 
            descuento = ?,
            modificado_por = ?
            WHERE 
            id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getNombre(),
                $datos->getDomicilio(),
                $datos->getIdLocalidad(),
                $datos->getEmail(),
                $datos->getTelefono(),
                $datos->getIdTipoDocumento(),
                $datos->getDocumento(),
                $datos->getIdCondicionIva(),
                $datos->getDescuento(),
                $datos->getModificadoPor(),
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
            $stmt = $connection->prepare("DELETE FROM clientes WHERE id = ?");
            $stmt->execute([$datos->getId()]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Modules\Presupuesto\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Exceptions\DatabaseException;

class PresupuestosRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
            presupuestos.id,
            sucursales.nombre AS nombre_sucursal,
            presupuestos.fecha,
            clientes.nombre AS nombre_cliente,
            presupuestos.id_estado,
            presupuestos.total,
            empleados.nombre AS nombre_empleado,
            tipo_enmarcacion.nombre AS tipo_enmarcacion_nombre,
            presupuestos.comentarios,
            usuario_creador.usuario AS creado_por,
            usuario_modificador.usuario AS modificado_por
            FROM 
                presupuestos
            LEFT JOIN sucursales
                ON presupuestos.id_sucursal = sucursales.id
            LEFT JOIN clientes
                ON presupuestos.id_cliente = clientes.id
            LEFT JOIN empleados
                ON presupuestos.id_empleado = empleados.id
            LEFT JOIN tipo_enmarcacion
                ON tipo_enmarcacion.id = presupuestos.id_tipo_enmarcacion
            LEFT JOIN usuarios AS usuario_creador
                ON usuario_creador.id = presupuestos.creado_por
            LEFT JOIN usuarios AS usuario_modificador
                ON usuario_modificador.id = presupuestos.modificado_por";

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
            $stmt = $connection->prepare("SELECT * FROM presupuestos WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function create(object $datos): array
    {
        try {
            $connection = Database::getConnection();
            $SQL = "INSERT INTO 
                    presupuestos 
                    (id_sucursal, 
                    fecha,
                    id_cliente, 
                    id_estado,
                    id_empleado,
                    id_tipo_enmarcacion,
                    comentarios,
                    total,
                    cliente_nombre,
                    cliente_telefono,
                    cliente_email,
                    cliente_domicilio,
                    alto,
                    ancho,
                    id_objeto_a_enmarcar,
                    modelo, 
                    propio,
                    creado_por) 
                    VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getIdSucursal(),
                $datos->getFecha(),
                $datos->getIdCliente(),
                $datos->getIdEstado(),
                $datos->getIdEmpleado(),
                $datos->getIdTipoEnmarcacion(),
                $datos->getComentarios(),
                $datos->getTotal(),
                $datos->getClienteNombre(),
                $datos->getClienteTelefono(),
                $datos->getClienteEmail(),
                $datos->getClienteDomicilio(),
                $datos->getAlto(),
                $datos->getAncho(),
                $datos->getIdObjetoaEnmarcar(),
                $datos->getModelo(),
                $datos->getpropio(),
                $datos->getCreadoPor()
            ]);

            $id = $connection->lastInsertId();

            return self::findById($id);
        } catch (DatabaseException $e) {
            LogHelper::error('Database: ' . $e->getMessage());
            throw new DatabaseException('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public static function update(array $datos): bool
    {
        try {
            $connection = Database::getConnection();
            // Implementar la actualización en la tabla presupuestos
            return true;
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function delete(int $id): bool
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("DELETE FROM presupuestos WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public static function calcularCantidades($alto, $ancho, $id): bool
    {
        try {
            $connection = Database::getConnection();
            $connection->beginTransaction();

            // Update para tipo_calculo = 2
            $SQL1 = "UPDATE 
                    presupuestos_detalle
                    LEFT JOIN 
                    materiales ON materiales.id = presupuestos_detalle.materiales_id
                    LEFT JOIN
                    tipo_materiales ON materiales.id_tipo_materiales = tipo_materiales.id
                    SET 
                    presupuestos_detalle.cantidad = ? * ? * ?
                    WHERE
                    tipo_materiales.tipo_calculo = 2 
                    AND presupuestos_detalle.id_presupuestos = ?";

            $stmt1 = $connection->prepare($SQL1);
            $stmt1->execute([
                $alto,
                $ancho,
                $_ENV['DESPERDICIOS'],
                $id
            ]);

            // Update para tipo_calculo = 3
            $SQL2 = "UPDATE 
                    presupuestos_detalle
                    LEFT JOIN 
                    materiales ON materiales.id = presupuestos_detalle.materiales_id
                    LEFT JOIN
                    tipo_materiales ON materiales.id_tipo_materiales = tipo_materiales.id
                    SET 
                    presupuestos_detalle.cantidad = 2 * (? + ?) * ?
                    WHERE
                    tipo_materiales.tipo_calculo = 3 
                    AND presupuestos_detalle.id_presupuestos = ?";

            $stmt2 = $connection->prepare($SQL2);
            $stmt2->execute([
                $alto,
                $ancho,
                $_ENV['DESPERDICIOS'],
                $id
            ]);

            $connection->commit();

            return true;
        } catch (PDOException $e) {
            LogHelper::error($e->getMessage());
            $connection->rollBack();
            return false;
        }
    }
}

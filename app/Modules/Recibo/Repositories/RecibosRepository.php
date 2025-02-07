<?php

namespace App\Modules\Recibo\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Modules\Recibo\Filters\FindFilter;
//use App\Modules\Recibo\Repositories\recibosDetalleRepository;

class RecibosRepository
{

    public static function find()
    {
        try {
            $filtro = " WHERE recibos.`suspendido` = 0 ";
            $filters = FindFilter::getFilters();
            if ($filters) {
                $filtro .= " AND " . implode(" AND ", $filters);
            }



            $connection = Database::getConnection();
            $SQL = "SELECT  recibos.`id`, 
                        recibos.`numero`,
                        recibos.`id_cliente`, 
                        recibos.`cliente_nombre`, 
                        recibos.`cliente_email`, 
                        recibos.`cliente_domicilio`, 
                        recibos.`cliente_telefono`, 
                        DATE_FORMAT(recibos.fecha, '%d/%m/%Y') AS fecha,
                        recibos.`total`, 
                        recibos.`id_orden_de_trabajo`, 
                        recibos.`id_forma_de_pago`, 
                        recibos.`suspendido`, 
                        recibos.`cargado_por`,
                        presupuestos.numero_orden  
                    FROM recibos 
                        LEFT JOIN presupuestos on recibos.id_orden_de_trabajo = presupuestos.id
                    " . $filtro . "
                    order by id desc";



            //echo $SQL;
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
            $SQL = "SELECT 
                    recibos.id AS recibo_id,
                    recibos.cliente_nombre,
                    recibos.cliente_email,
                    recibos.cliente_domicilio,
                    recibos.cliente_telefono,
                    recibos.fecha,
                    recibos.total,
                    recibos.id_orden_de_trabajo,
                    recibos.id_forma_de_pago,
                    recibos.suspendido,
                    recibos.cargado_por,
                    recibos.numero,
                    recibos.id_sucursal,
                    sucursales.nombre AS nombreSucursal
                    FROM 
                    recibos 
                    INNER JOIN
                    sucursales
                    ON
                    recibos.id_sucursal=sucursales.id
                    WHERE 
                    recibos.id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function create(object $datos)
    {
        try {
            $connection = Database::getConnection();

            $SQL = "INSERT INTO 
                    recibos 
                    (`id_cliente`, 
                    `cliente_nombre`, 
                    `cliente_email`, 
                    `cliente_domicilio`, 
                    `cliente_telefono`, 
                    `fecha`, 
                    `total`, 
                    `id_orden_de_trabajo`, 
                    `id_forma_de_pago`, 
                    `suspendido`, 
                    `cargado_por`,
                    `numero`,
                    `id_sucursal`) 
                    VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datos->getIdcliente(),
                $datos->getClienteNombre(),
                $datos->getClienteEmail(),
                $datos->getClienteDomicilio(),
                $datos->getClienteTelefono(),
                $datos->getFecha(),
                $datos->getTotal(),
                $datos->getIdOrdenDeTrabajo(),
                $datos->getIdFormaDePago(),
                $datos->getSuspendido(),
                $datos->getCargadoPor(),
                self::findLastNumber($datos->getIdSucursal()) + 1,
                $datos->getIdSucursal()
            ]);

            $id = $connection->lastInsertId();
            foreach ($datos->getDetalle() as $detalle) {
                $SQL = "INSERT INTO 
                recibos_detalle 
                (   `idRecibo`, 
                    `idFormaDePago`, 
                    `monto`,
                    observaciones ) 
                VALUES 
                (?, ?, ?, ?)";
                $stmt = $connection->prepare($SQL);
                $stmt->execute([
                    $id,
                    $detalle['id_forma_de_pago'],
                    $detalle['monto'],
                    $detalle['observaciones']
                ]);
            }
            return self::findById($id);
        } catch (PDOException $e) {
            print_r($e);
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }


    public static function findLastNumber(int $id_sucursal): int
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT numero FROM recibos WHERE id_sucursal = ? ORDER BY numero DESC LIMIT 1");
            $stmt->execute([$id_sucursal]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['numero'] ?? 0;
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
            $stmt = $connection->prepare("DELETE FROM recibos WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public function crearRecibo($datosPresupuesto, $reserva, $idPresupuesto, $numeroRecibo)
    {

        try {
            $connection = Database::getConnection();

            $SQL = "INSERT INTO 
                recibos 
                (id_cliente, 
                cliente_nombre, 
                cliente_email, 
                cliente_domicilio, 
                cliente_telefono, 
                fecha, 
                total, 
                id_orden_de_trabajo, 
                id_forma_de_pago, 
                suspendido, 
                cargado_por, 
                numero, 
                id_sucursal) 
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([
                $datosPresupuesto['id_cliente'],
                $datosPresupuesto['cliente_nombre'],
                $datosPresupuesto['cliente_email'],
                $datosPresupuesto['cliente_domicilio'],
                $datosPresupuesto['cliente_telefono'],
                $datosPresupuesto['fecha'],
                $reserva,
                $idPresupuesto,
                0, // ID FORMA DE PAGO 0 POR DEFAULT
                0, // SUSPENDIDO 0 POR DEFAULT
                $datosPresupuesto['creado_por'],
                $numeroRecibo,
                $datosPresupuesto['id_sucursal']
            ]);

            return $connection->lastInsertId();
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public function crearReciboDetalle($idRecibo, $formaPago, $monto)
    {
        try {
            $connection = Database::getConnection();
            $SQL = "INSERT INTO 
                recibos_detalle 
                (idRecibo, idFormaDePago, monto, observaciones) 
                VALUES 
                (?, ?, ?, ?)";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$idRecibo, $formaPago, $monto, '']);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
}

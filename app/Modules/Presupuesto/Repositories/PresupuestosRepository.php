<?php

namespace App\Modules\Presupuesto\Repositories;

use PDOException;
use App\Config\Database;
use App\Helpers\LogHelper;
use App\Helpers\PaginatorHelper;
use App\Modules\Presupuesto\Filters\FindFilter;
use App\Modules\Presupuesto\Repositories\BaseRepository;

class PresupuestosRepository extends BaseRepository
{

    public static function find()
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                    presupuestos.id,
                    sucursales.nombre AS nombre_sucursal,
                    sucursales.id AS id_sucursal,
                    DATE_FORMAT(presupuestos.fecha, '%d/%m/%Y') AS fecha,
                    presupuestos.cliente_nombre as nombre_cliente,
                    presupuestos.id_estado,
                    presupuestos.total,
                    empleados.nombre AS nombre_empleado,
                    tipo_enmarcacion.nombre AS tipo_enmarcacion_nombre,
                    presupuestos.comentarios,
                    usuario_creador.usuario AS creado_por,
                    usuario_modificador.usuario AS modificado_por,
                    recibos.total AS pagos
            FROM 
                presupuestos
                    LEFT JOIN sucursales ON presupuestos.id_sucursal = sucursales.id
                    LEFT JOIN clientes ON presupuestos.id_cliente = clientes.id
                    LEFT JOIN empleados ON presupuestos.id_empleado = empleados.id
                    LEFT JOIN tipo_enmarcacion ON tipo_enmarcacion.id = presupuestos.id_tipo_enmarcacion
                    LEFT JOIN usuarios AS usuario_creador ON usuario_creador.id = presupuestos.creado_por
                    LEFT JOIN usuarios AS usuario_modificador ON usuario_modificador.id = presupuestos.modificado_por
                    LEFT JOIN (SELECT `id_orden_de_trabajo`, sum(`total`) as total FROM `recibos` where `suspendido` = 0 group by `id_orden_de_trabajo`  ) as recibos ON recibos.id_orden_de_trabajo = presupuestos.id
                    
                    ";

            $filters = FindFilter::getFilters();
            if ($filters) {
                $SQL .= " WHERE " . implode(" AND ", $filters);
            }

            $SQL .= " ORDER BY presupuestos.id DESC";

            $paginator = new PaginatorHelper($connection, $SQL);

            return $paginator->getPaginatedResults();
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function saldo(int $id)
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                        presupuestos.id,
                        presupuestos.total,
                        recibos.total AS pagos,
                        presupuestos.total - recibos.total AS saldo
                    FROM 
                        presupuestos
                    LEFT JOIN (SELECT `id_orden_de_trabajo`, sum(`total`) as total FROM `recibos` where `suspendido` = 0 group by `id_orden_de_trabajo`  ) as recibos ON recibos.id_orden_de_trabajo = presupuestos.id
                    WHERE presupuestos.id = ?";

            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['saldo'] ?? 0;

        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function pagos(int $id)
    {
        try {
            $connection = Database::getConnection();
            $SQL = "SELECT 
                        presupuestos.id,
                        presupuestos.total,
                        recibos.total AS pagos,
                        presupuestos.total - recibos.total AS saldo
                    FROM 
                        presupuestos
                    LEFT JOIN (SELECT `id_orden_de_trabajo`, sum(`total`) as total FROM `recibos` where `suspendido` = 0 group by `id_orden_de_trabajo`  ) as recibos ON recibos.id_orden_de_trabajo = presupuestos.id
                    WHERE presupuestos.id = ?";

            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['pagos'] ?? 0;

        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function findById(int $id)
    {
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare("SELECT presupuestos.* ,
                                                COALESCE(recibos.total,0) as pagos,
                                                COALESCE(presupuestos.total,0) - COALESCE(recibos.total,0) as saldo
                                            FROM presupuestos 
                                                LEFT JOIN (SELECT `id_orden_de_trabajo`, sum(`total`) as total FROM `recibos` where `suspendido` = 0 group by `id_orden_de_trabajo`  ) as recibos ON recibos.id_orden_de_trabajo = presupuestos.id
                                            WHERE presupuestos.id = ?");
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
            $numero_orden = 0;
            //$numero_orden = self::findOrderNumber($datos->getIdSucursal());

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
                    sub_total,
                    descuento,
                    cliente_nombre,
                    cliente_telefono,
                    cliente_email,
                    cliente_domicilio,
                    alto,
                    ancho,
                    id_objeto_a_enmarcar,
                    modelo, 
                    propio,
                    creado_por,
                    cantidad,
                    estado_orden_trabajo,
                    numero_orden) 
                    VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
                $datos->getSubTotal(),
                $datos->getDescuento(),
                $datos->getClienteNombre(),
                $datos->getClienteTelefono(),
                $datos->getClienteEmail(),
                $datos->getClienteDomicilio(),
                $datos->getAlto(),
                $datos->getAncho(),
                $datos->getIdObjetoaEnmarcar(),
                $datos->getModelo(),
                $datos->getpropio(),
                $datos->getCreadoPor(),
                $datos->getCantidad(),
                $datos->getEstadoOrdenTrabajo(),
                $numero_orden
            ]);

            $id = $connection->lastInsertId();

            return self::findById($id);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
    
    public static function update(object $datos)
    {
        try {
            $repository = new self();
            $repository->updateData('presupuestos', $datos->toArray(), 'id', $datos->getId());
            
            return self::findById($datos->getId());
        } catch (PDOException $e) {

            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
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
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
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
                    materiales ON materiales.id = presupuestos_detalle.id_material
                    LEFT JOIN
                    tipo_material ON materiales.id_tipo_material = tipo_material.id
                    SET 
                    presupuestos_detalle.cantidad = ((? * ?) / 10000) * ?
                    WHERE
                    tipo_material.tipo_calculo = 2 
                    AND presupuestos_detalle.id_presupuesto = ?";

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
                    materiales ON materiales.id = presupuestos_detalle.id_material
                    LEFT JOIN
                    tipo_material ON materiales.id_tipo_material = tipo_material.id
                    SET 
                    presupuestos_detalle.cantidad = (2 * (? + ?) / 100) * ?
                    WHERE
                    tipo_material.tipo_calculo = 3 
                    AND presupuestos_detalle.id_presupuesto = ?";

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
            LogHelper::error($e);
            $connection->rollBack();
            return false;
        }
    }

    public static function calcularTotales($id)
    {
        try {
            $connection = Database::getConnection();
            $SQL = "UPDATE presupuestos
                    LEFT JOIN tipo_enmarcacion ON tipo_enmarcacion.id = presupuestos.id_tipo_enmarcacion
                    LEFT JOIN objetos_a_enmarcar ON objetos_a_enmarcar.id = presupuestos.id_objeto_a_enmarcar
                    LEFT JOIN 
                    (SELECT presupuestos_detalle.id_presupuesto, 		
                            SUM(presupuestos_detalle.precio_unitario * presupuestos_detalle.cantidad) as total 
                    FROM presupuestos_detalle 
                    GROUP BY presupuestos_detalle.id_presupuesto) as totalMateriales 
                    ON totalMateriales.id_presupuesto = presupuestos.id
                    LEFT JOIN (SELECT presupuestos_extras.id_presupuesto, 
                          SUM(presupuestos_extras.precio_unitario * presupuestos_extras.cantidad) as total
                          FROM   presupuestos_extras
                          GROUP BY presupuestos_extras.id_presupuesto) as totalExtras 
                      ON totalExtras.id_presupuesto = presupuestos.id
                    SET 
                    presupuestos.sub_total = (((IFNULL(totalMateriales.total,0)+ IFNULL(totalExtras.total,0)) * (1+(COALESCE(tipo_enmarcacion.comisionPorcentual, 0)/100)) * 
                    (1+(COALESCE(objetos_a_enmarcar.extra_porcentual, 0)/100)) + COALESCE(tipo_enmarcacion.comisionFija, 0) + COALESCE(objetos_a_enmarcar.extra_fijo, 0)))*presupuestos.cantidad
                    WHERE presupuestos.id = ?";
            $stmt1 = $connection->prepare($SQL);
            $stmt1->execute([
                $id
            ]);
            $SQL2 = "UPDATE presupuestos
            SET 
            presupuestos.total = (IFNULL(presupuestos.sub_total,0) - ((IFNULL(presupuestos.descuento,0)/100)*IFNULL(presupuestos.sub_total,0)))
            WHERE presupuestos.id = ?;";
            $stmt2 = $connection->prepare($SQL2);
            $stmt2->execute([
                $id
            ]);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function findOrderNumber($id_sucursal)
    {
        $SQL = "SELECT 
                max(numero_orden) + 1 AS proximo_numero 
                FROM 
                presupuestos 
                WHERE 
                id_sucursal = ?";
        try {
            $connection = Database::getConnection();
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id_sucursal]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }

    public static function findByIdToPDF(int $id)
    {
        try {
            $connection = Database::getConnection();

            $SQL = "SELECT 
                    DATE_FORMAT(presupuestos.fecha, '%d/%m/%Y') AS fecha,
                    DATE_FORMAT(presupuestos.fecha_entrega, '%d/%m/%Y') AS fecha_entrega,
                    presupuestos.cliente_nombre,
                    presupuestos.cliente_email,
                    presupuestos.cliente_domicilio,
                    presupuestos.cliente_telefono,
                    presupuestos.numero_orden,
                    presupuestos.reserva,
                    presupuestos.total,
                    presupuestos.modelo,
                    presupuestos.alto,
                    presupuestos.ancho,
                    presupuestos.cantidad,
                    tipo_enmarcacion.nombre AS tipo_enmarcacion_nombre,
                    CASE 
					WHEN presupuestos.propio = 1 THEN 'propio' 
					ELSE '' 
					END AS propio,
                    presupuestos.comentarios,
                    objetos_a_enmarcar.nombre AS nombre_objeto_enmarcar,
                    sucursales.nombre AS sucursal_nombre
                    FROM 
                    presupuestos 
                    LEFT JOIN 
                    sucursales
                    ON
                    presupuestos.id_sucursal=sucursales.id
                    LEFT JOIN 
                    objetos_a_enmarcar
                    ON
                    presupuestos.id_objeto_a_enmarcar=objetos_a_enmarcar.id
                    LEFT JOIN 
                    tipo_enmarcacion
                    ON
                    presupuestos.id_tipo_enmarcacion=tipo_enmarcacion.id
                    WHERE 
                    presupuestos.id = ?";
            $stmt = $connection->prepare($SQL);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new PDOException('Error: ' . $e->getMessage());
        }
    }
}

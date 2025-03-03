<?php

namespace App\Modules\OrdenDeTrabajo\Services;

use Exception;
use PDOException;
use Dompdf\Dompdf;

use Dompdf\Options;
use App\Helpers\LogHelper;
use App\Helpers\RenderHelper;
use App\Modules\Recibo\Repositories\RecibosRepository;
use App\Modules\Presupuesto\Requests\PresupuestosUpdateRequest;
use App\Modules\Presupuesto\Repositories\PresupuestosRepository;
use App\Modules\OrdenDeTrabajo\Repositories\OrdenDeTrabajoRepository;
use App\Modules\Presupuesto\Repositories\PresupuestosDetalleRepository;

class OrdenDeTrabajoService
{

    public function create(PresupuestosUpdateRequest $request): array
    {

        try {
            $response = PresupuestosRepository::update($request);
            PresupuestosRepository::calcularCantidades($request->getAlto(), $request->getAncho(), $request->getId());
            PresupuestosRepository::calcularTotales($request->getId());
            $item = PresupuestosRepository::findById($response['id']);
            OrdenDeTrabajoRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new \Exception('Error al crear una orden de trabajo. Inténtalo más tarde.');
        }
    }

    public function generar($request)
    {
        try {
            $presupuestoRepository = new PresupuestosRepository();
            $reciboRepository = new RecibosRepository();

            $datosPresupuesto = $presupuestoRepository->findByPresupuestoId($request->id_presupuesto);

            if (!$datosPresupuesto) {
                throw new Exception("Presupuesto no encontrado.");
            }

            $numeroOrden = OrdenDeTrabajoRepository::findLastNumber($datosPresupuesto['id_sucursal']) + 1;
            $presupuestoRepository->actualizarEstado( 
                $request->fecha_entrega, 
                $request->reserva, 
                $numeroOrden,
                $request->nombre,
                $request->telefono,
                $request->email,
                $request->domicilio,
                $request->comentarios,
                $request->id_presupuesto);

            $numeroRecibo = $reciboRepository->findLastNumber($datosPresupuesto['id_sucursal']) + 1;
            $idRecibo = $reciboRepository->crearRecibo($datosPresupuesto, $request->reserva, $request->id_presupuesto, $numeroRecibo);
            $reciboRepository->crearReciboDetalle($idRecibo, $request->forma_pago, $request->reserva);

            return $presupuestoRepository->findByPresupuestoId($request->id_presupuesto);

        } catch (PDOException $e) {
            LogHelper::error($e);
            throw new \Exception('Error al crear una orden de trabajo. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = OrdenDeTrabajoRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran ordenes de trabajos.');
        }
        return $items;
    }

    public function getAllOrders(): array
    {
        $items = OrdenDeTrabajoRepository::findAll();

        if (!$items) {
            throw new \Exception('No se encuentran ordenes de trabajos.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = OrdenDeTrabajoRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra ordendetrabajo.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = OrdenDeTrabajoRepository::update($request);
            if (!$item) {
                throw new \Exception('OrdenDeTrabajo inexistente.');
            }
            return [$item];
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar unn ordendetrabajo. Inténtalo más tarde.');
        }
    }

    public function updateStatus($request, $id): array
    {
        try {
            $item = OrdenDeTrabajoRepository::updateStatus($request, $id);
            if (!$item) {
                throw new \Exception('OrdenDeTrabajo inexistente.');
            }
            return [$item];
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar unn ordendetrabajo. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = OrdenDeTrabajoRepository::delete($request);
            if (!$item) {
                throw new \Exception('OrdenDeTrabajo inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar unn ordendetrabajo. Inténtalo más tarde.');
        }
    }

    public function pdfOrdenCliente($id)
    {
        ob_start(); // Iniciar buffer de salida para evitar problemas con headers

        $presupuesto = PresupuestosRepository::findByIdToPDF($id);
        $presupuestoDetalle = PresupuestosDetalleRepository::findByPresupuestoId($id);

        // Evitar errores si algún dato es null
        $datos = [
            'cliente_nombre' => $presupuesto['cliente_nombre'] ?? '',
            'cliente_email' => $presupuesto['cliente_email'] ?? '',
            'cliente_domicilio' => $presupuesto['cliente_domicilio'] ?? '',
            'cliente_telefono' => $presupuesto['cliente_telefono'] ?? '',
            'objeto_tipo' => $presupuesto['tipo_enmarcacion_nombre'] ?? '',
            'objeto_modelo' => $presupuesto['modelo'] ?? '',
            'objeto_propiedad' => $presupuesto['propio'] ?? '',
            'objeto_comentario' => $presupuesto['comentarios'] ?? '',
            'detalle_tipo' => $presupuesto['tipo_enmarcacion_nombre'] ?? '',
            'detalle_alto' => $presupuesto['alto'] ?? '',
            'detalle_ancho' => $presupuesto['ancho'] ?? '',
            'numero_orden' => str_pad($presupuesto['numero_orden'], 4, "0", STR_PAD_LEFT) ?? 0000,
            'sucursal_nombre' => $presupuesto['sucursal_nombre'] ?? '',
            'fecha_recepcion' => $presupuesto['fecha_orden_trabajo'] ?? '',
            'fecha_entrega' => $presupuesto['fecha_entrega'] ?? '',
            'saldo' => $presupuesto['total'] - $presupuesto['reserva'] ?? '',
            'total' => $presupuesto['total'] ?? '',
            'reserva' => $presupuesto['reserva'] ?? '0.00',
            'cantidad' => $presupuesto['cantidad'],
            'descripcion_papeleria' => $presupuesto['descripcion_papeleria']
        ];

        // Construcción de la tabla en HTML
        $tablaMaterialesHtml = "";
        foreach ($presupuestoDetalle as $item) {
            $tablaMaterialesHtml .= "<tr style='border: 1px solid black;'>
                <td style='text-align:left; border: 1px solid black; width: 200px;'>{$item['nombre_materiales']}</td>
                <td style='text-align:center; width:10px; border: 1px solid black;'>{$item['cm']}</td>
                <td style='text-align:center; width:10px; border: 1px solid black;'>{$item['cs']}</td>
                <td style='text-align:left; border: 1px solid black;'>{$item['descripcion']}</td>
            </tr>";
        }

        $html =  RenderHelper::pdf(
            dirname(__DIR__,2).'/OrdenDeTrabajo/Views/ordenCliente.php', 
            array_merge($datos, ['tabla_materiales' => $tablaMaterialesHtml])
        );

        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $css = file_get_contents(dirname(__DIR__, 1) . '/Views/css/ordenCliente.css');
        $html = "<style>$css</style>" . $html;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        ob_end_clean(); // Limpiar cualquier salida antes de enviar el PDF
        $dompdf->stream('ordenCliente.pdf', ['Attachment' => false]);

        exit; // Finalizar script para evitar cualquier salida extra
    }

    public function pdfOrdenTaller($id)
    {
        ob_start(); // Iniciar buffer de salida para evitar problemas con headers

        $presupuesto = PresupuestosRepository::findByIdToPDF($id);
        $presupuestoDetalle = PresupuestosDetalleRepository::findByPresupuestoId($id);

        // Evitar errores si algún dato es null
        $datos = [
            'cliente_nombre' => $presupuesto['cliente_nombre'] ?? '',
            'cliente_email' => $presupuesto['cliente_email'] ?? '',
            'cliente_domicilio' => $presupuesto['cliente_domicilio'] ?? '',
            'cliente_telefono' => $presupuesto['cliente_telefono'] ?? '',
            'objeto_tipo' => $presupuesto['tipo_enmarcacion_nombre'] ?? '',
            'objeto_modelo' => $presupuesto['modelo'] ?? '',
            'objeto_propiedad' => $presupuesto['propio'] ?? '',
            'objeto_comentario' => $presupuesto['comentarios'] ?? '',
            'objeto_comentarios_taller' => $presupuesto['comentarios_taller'] ?? '',
            'detalle_tipo' => $presupuesto['tipo_enmarcacion_nombre'] ?? '',
            'detalle_alto' => $presupuesto['alto'] ?? '',
            'detalle_ancho' => $presupuesto['ancho'] ?? '',
            'numero_orden' => str_pad($presupuesto['numero_orden'], 4, "0", STR_PAD_LEFT) ?? 0000,
            'sucursal_nombre' => $presupuesto['sucursal_nombre'] ?? '',
            'fecha_recepcion' => $presupuesto['fecha'] ?? '',
            'fecha_entrega' => $presupuesto['fecha_entrega'] ?? '',
            'saldo' => $presupuesto['total'] - $presupuesto['reserva'] ?? '',
            'total' => $presupuesto['total'] ?? '',
            'reserva' => $presupuesto['reserva'] ?? '0.00',
            'posicion' => $presupuesto['posicion'] ?? '',
            'cantidad' => $presupuesto['cantidad'] ?? '',
            'nombre_objeto_enmarcar' => $presupuesto['nombre_objeto_enmarcar'] ?? ''
        ];

        // Construcción de la tabla en HTML
        $tablaMaterialesHtml = "";
        foreach ($presupuestoDetalle as $item) {
            $tablaMaterialesHtml .= "<tr>
                <td style='text-align:left; width:200px;'>{$item['nombre_materiales']}</td>
                <td style='text-align:center; width:10px;'>{$item['cm']}</td>
                <td style='text-align:center; width:10px;'>{$item['cs']}</td>
                <td style='text-align:center; width:10px;'>{$item['posicion']}</td>
                <td style='text-align:left;'>{$item['descripcion']}</td>
            </tr>";
        }

        $html =  RenderHelper::pdf(
            dirname(__DIR__,2).'/OrdenDeTrabajo/Views/ordenTaller.php', 
            array_merge($datos, ['tabla_materiales' => $tablaMaterialesHtml])
        );

        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $css = file_get_contents(dirname(__DIR__, 1) . '/Views/css/ordenTaller.css');
        $html = "<style>$css</style>" . $html;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        ob_end_clean(); // Limpiar cualquier salida antes de enviar el PDF
        $dompdf->stream('ordenTaller.pdf', ['Attachment' => false]);

        exit; // Finalizar script para evitar cualquier salida extra
    }

    public function actualizarOrden($request){

        try {
            $item = OrdenDeTrabajoRepository::actualizarOrden($request);
            if (!$item) {
                throw new \Exception('OrdenDeTrabajo inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar unn ordendetrabajo. Inténtalo más tarde.');
        }

    }

}

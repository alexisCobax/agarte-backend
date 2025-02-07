<?php

namespace App\Modules\OrdenDeTrabajo\Services;

use Exception;
use PDOException;
use Dompdf\Dompdf;

use Dompdf\Options;
use App\Helpers\LogHelper;
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
            //LogHelper::error($e->getMessage());
            throw new \Exception('Error al crear una orden de trabajo. Inténtalo más tarde.');
        }

    }

    public function generar($request): array
    {
        try {
            //PresupuestosRepository::calcularTotales($request->id_presupuesto);
            $item = OrdenDeTrabajoRepository::generar($request);
            return ["datos" => $item];
        } catch (Exception $e) {
            //LogHelper::error($e->getMessage());
            echo $e->getMessage();die;
            throw new \Exception('Error al crear unn orden de trabajo. Inténtalo más tarde.');
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
            'fecha_recepcion' => $presupuesto['fecha'] ?? '',
            'fecha_entrega' => $presupuesto['fecha_entrega'] ?? '',
            'saldo' => $presupuesto['total']-$presupuesto['reserva'] ?? '',
            'total' => $presupuesto['total'] ?? '',
            'reserva' => $presupuesto['reserva'] ?? '0.00',
            'cantidad' => $presupuesto['cantidad']
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
    
        // Cargar la plantilla HTML y reemplazar variables
        $html = $this->cargarHtml(__DIR__ . '/../Views/ordenCliente.php', array_merge($datos, ['tabla_materiales' => $tablaMaterialesHtml]));
    
        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
    
        $dompdf = new Dompdf($options);
        $css = file_get_contents(dirname(__DIR__,1).'/Views/css/ordenCliente.css');
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
            'detalle_tipo' => $presupuesto['tipo_enmarcacion_nombre'] ?? '',
            'detalle_alto' => $presupuesto['alto'] ?? '',
            'detalle_ancho' => $presupuesto['ancho'] ?? '',
            'numero_orden' => str_pad($presupuesto['numero_orden'], 4, "0", STR_PAD_LEFT) ?? 0000,
            'sucursal_nombre' => $presupuesto['sucursal_nombre'] ?? '',
            'fecha_recepcion' => $presupuesto['fecha'] ?? '',
            'fecha_entrega' => $presupuesto['fecha_entrega'] ?? '',
            'saldo' => $presupuesto['total']-$presupuesto['reserva'] ?? '',
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
    
        // Cargar la plantilla HTML y reemplazar variables
        $html = $this->cargarHtml(__DIR__ . '/../Views/ordenTaller.php', array_merge($datos, ['tabla_materiales' => $tablaMaterialesHtml]));
    
        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
    
        $dompdf = new Dompdf($options);
        $css = file_get_contents(dirname(__DIR__,1).'/Views/css/ordenTaller.css');
        $html = "<style>$css</style>" . $html;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        ob_end_clean(); // Limpiar cualquier salida antes de enviar el PDF
        $dompdf->stream('ordenTaller.pdf', ['Attachment' => false]);
    
        exit; // Finalizar script para evitar cualquier salida extra
    }
    

    // Función para cargar la plantilla HTML y reemplazar variables
    function cargarHtml($ruta, $variables = [])
    {
        $rutaCompleta = __DIR__ . '/../Views/' . basename($ruta);
    
        if (!file_exists($rutaCompleta)) {
            die("Error: No se encontró la plantilla HTML en $rutaCompleta.");
        }
    
        $html = file_get_contents($rutaCompleta);
    
        foreach ($variables as $key => $value) {
            $html = str_replace("{{{$key}}}", $value ?? '', $html); // Convertir null en cadena vacía
        }
    
        return $html;
    }
    
}

<?php

namespace App\Modules\Recibo\Services;

use PDOException;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Modules\Recibo\Repositories\RecibosRepository;
use App\Modules\Presupuesto\Repositories\PresupuestosRepository;
use App\Modules\Presupuesto\Repositories\PresupuestosDetalleRepository;

class RecibosService
{
    public function create($request): array
    {
        try {
            $item = RecibosRepository::create($request);

            //$item = recibosDetalleRepository::create($request);

            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un recibos. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = RecibosRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran recibos.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = RecibosRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra recibos.');
        }
        return $item;
    }

    public function update($request): array
    {
        try {
            $item = RecibosRepository::update($request);
            if (!$item) {
                throw new \Exception('Recibos inexistente.');
            }
            return [$item];
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar un recibos. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = RecibosRepository::delete($request);
            if (!$item) {
                throw new \Exception('Recibos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un recibos. Inténtalo más tarde.');
        }
    }

    public function pdfRecibo($id)
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
            'numero_orden' => $presupuesto['numero_orden'] ?? '',
            'sucursal_nombre' => $presupuesto['sucursal_nombre'] ?? '',
            'fecha_recepcion' => $presupuesto['fecha'] ?? '',
            'fecha_entrega' => $presupuesto['fecha_entrega'] ?? '',
            'saldo' => $presupuesto['total']-$presupuesto['reserva'] ?? '',
            'total' => $presupuesto['total'] ?? '',
            'reserva' => $presupuesto['reserva'] ?? '',
        ];
        
        // Cargar la plantilla HTML y reemplazar variables
        $html = $this->cargarHtml(__DIR__ . '/../Views/recibo.php', array_merge($datos));
    
        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
    
        $dompdf = new Dompdf($options);
        $css = file_get_contents(dirname(__DIR__,1).'/Views/css/recibo.css');
        $html = "<style>$css</style>" . $html;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        ob_end_clean(); // Limpiar cualquier salida antes de enviar el PDF
        $dompdf->stream('recibo.pdf', ['Attachment' => false]);
    
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
<?php

namespace App\Modules\Recibo\Services;

use PDOException;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Modules\Recibo\Repositories\RecibosRepository;
use App\Modules\Recibo\Repositories\RecibosDetalleRepository;;

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
    
        $recibo = RecibosRepository::findById($id);
        $reciboDetalle = RecibosDetalleRepository::findByReciboId($id);
    
        // Evitar errores si algún dato es null
        $datos = [
            'recibo_id' => str_pad($recibo['recibo_id'], 4, "0", STR_PAD_LEFT) ?? 0000,
            'cliente_nombre' => $recibo['cliente_nombre'] ?? '',
            'cliente_email' => $recibo['cliente_email'] ?? '',
            'cliente_domicilio' => $recibo['cliente_domicilio'] ?? '',
            'cliente_telefono' => $recibo['cliente_telefono'] ?? '',
            'nombre_sucursal' => $recibo['nombreSucursal'] ?? '',
            'forma_pago' => $reciboDetalle['formaPagoNombre'] ?? '',
            'total' => $recibo['total'] ?? '',
            'monto' => $reciboDetalle['monto'] ?? ''
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
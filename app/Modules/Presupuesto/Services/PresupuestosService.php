<?php

namespace App\Modules\Presupuesto\Services;

use PDOException;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Helpers\LogHelper;
use App\Modules\Presupuesto\Repositories\PresupuestosRepository;
use App\Modules\Presupuesto\Repositories\PresupuestosDetalleRepository;

class PresupuestosService
{

    public function createOrUpdate($createRequest,$updateRequest): array 
    {
        if ($createRequest->getId() == 0) {
            return $this->create($createRequest);
        } else {
            return $this->update($updateRequest);
        }
    }

    public function create(object $request): array
    {
        try {
                $response = PresupuestosRepository::create($request);
                PresupuestosRepository::calcularCantidades($request->getAlto(), $request->getAncho(), $response['id']);
                PresupuestosRepository::calcularTotales($response['id']);
                $item = PresupuestosRepository::findById($response['id']);
                return ["datos" => $item];
        } catch (PDOException $e) {
            //LogHelper::error($e->getMessage());
            throw new \Exception('Error al crear un presupuestos. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = PresupuestosRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran presupuestos.');
        }
        return $items;
    }

    public function get($request): array
    {
        $presupuesto = PresupuestosRepository::findById($request->getId());
        $presupuestoDetalle = PresupuestosDetalleRepository::findByPresupuestoId($request->getId());

        if (!$presupuesto) {
            throw new \Exception('No se encuentra presupuestos.');
        }
        return ["presupuesto" => $presupuesto, "detalle" => $presupuestoDetalle];
    }

    public function update($request): array
    {
        try {
            $response = PresupuestosRepository::update($request);
            PresupuestosRepository::calcularCantidades($request->getAlto(), $request->getAncho(), $request->getId());
            PresupuestosRepository::calcularTotales($request->getId());
            $item = PresupuestosRepository::findById($response['id']);
            return ["datos" => $item];
        } catch (PDOException $e) {
            //LogHelper::error($e->getMessage());
            throw new \Exception('Error al modificar un presupuestos. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = PresupuestosRepository::delete($request);
            if (!$item) {
                throw new \Exception('Presupuestos inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un presupuestos. Inténtalo más tarde.');
        }
    }


    public function pdfPresupuesto($id)
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
            'numero_presupuesto' => str_pad($presupuesto['id_presupuesto'], 4, "0", STR_PAD_LEFT) ?? 0000,
            'sucursal_nombre' => $presupuesto['sucursal_nombre'] ?? '',
            'fecha_recepcion' => $presupuesto['fecha'] ?? '',
            'fecha_entrega' => $presupuesto['fecha_entrega'] ?? '',
            'saldo' => $presupuesto['total']-$presupuesto['reserva'] ?? '',
            'total' => $presupuesto['total'] ?? '',
            'reserva' => $presupuesto['reserva'] ?? '',
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
        $html = $this->cargarHtml(__DIR__ . '/../Views/presupuesto.php', array_merge($datos, ['tabla_materiales' => $tablaMaterialesHtml]));
    
        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
    
        $dompdf = new Dompdf($options);
        $css = file_get_contents(dirname(__DIR__,1).'/Views/css/presupuesto.css');
        $html = "<style>$css</style>" . $html;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        ob_end_clean(); // Limpiar cualquier salida antes de enviar el PDF
        $dompdf->stream('presupuesto.pdf', ['Attachment' => false]);
    
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

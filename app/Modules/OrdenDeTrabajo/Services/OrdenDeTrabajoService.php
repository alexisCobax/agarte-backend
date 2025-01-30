<?php

namespace App\Modules\OrdenDeTrabajo\Services;

use PDOException;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Modules\Presupuesto\Requests\PresupuestosUpdateRequest;
use App\Modules\Presupuesto\Repositories\PresupuestosRepository;
use App\Modules\Presupuesto\Repositories\PresupuestosDetalleRepository;
use App\Modules\OrdenDeTrabajo\Repositories\OrdenDeTrabajoRepository;

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
            throw new \Exception('Error al modificar un presupuestos. Inténtalo más tarde.');
        }

        // try {
            
        //     $item = OrdenDeTrabajoRepository::create($request);
        //     PresupuestosRepository::calcularTotales($request->id_presupuesto);
        //     return ["datos" => $item];
        // } catch (PDOException $e) {
        //     throw new \Exception('Error al crear unn ordendetrabajo. Inténtalo más tarde.');
        // }
    }

    public function generate($request): array
    {
        try {
            $item = OrdenDeTrabajoRepository::create($request);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear unn ordendetrabajo. Inténtalo más tarde.');
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

    public function pdf($id)
    {

        $presupuesto = PresupuestosRepository::findByIdToPDF($id);
        $presupuestoDetalle = PresupuestosDetalleRepository::findByPresupuestoId($id);

        // Datos de prueba (en la versión real vendrán de la BD)
        $datos = [
            'cliente_nombre' => $presupuesto['cliente_nombre'],
            'cliente_email' => $presupuesto['cliente_email'],
            'cliente_domicilio' => $presupuesto['cliente_domicilio'],
            'cliente_telefono' => $presupuesto['cliente_telefono'],

            'objeto_tipo' => $presupuesto['tipo_enmarcacion_nombre'],
            'objeto_modelo' => $presupuesto['modelo'],
            'objeto_propiedad' => $presupuesto['propio'],
            'objeto_comentario' => $presupuesto['comentarios'],

            'detalle_tipo' => $presupuesto['tipo_enmarcacion_nombre'],
            'detalle_alto' => $presupuesto['alto'],
            'detalle_ancho' => $presupuesto['ancho'],

            'numero_orden' => $presupuesto['numero_orden'],
            'sucursal_nombre' =>$presupuesto['sucursal_nombre']
        ];

        // Construcción de la tabla en HTML
        $tablaMaterialesHtml = "";
        foreach ($presupuestoDetalle as $item) {
            $tablaMaterialesHtml .= "<tr>
        <td>{$item['nombre_materiales']}</td>
        <td>{$item['cantidad']}</td>
        <td>{$item['posicion']}</td>
        <td>{$item['observaciones']}</td>
    </tr>";
        }

        // Cargar la plantilla HTML y reemplazar variables
        //echo __DIR__. '\..\Views\orden.php';
        $html = $this->cargarHtml(__DIR__. '/../Views/orden.php', array_merge($datos, ['tabla_materiales' => $tablaMaterialesHtml]));

        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Mostrar el PDF en el navegador
        $dompdf->stream('orden_ejecucion.pdf', ['Attachment' => false]);
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
            $html = str_replace("{{{$key}}}", $value, $html);
        }

        return $html;
    }
}
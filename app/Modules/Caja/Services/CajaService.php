<?php

namespace App\Modules\Caja\Services;

use PDOException;
use App\Modules\Caja\Repositories\CajasRepository;
use App\Modules\Auth\Services\AuthService;

class CajasService
{
    public function create($requestCajas): array
    {
        try {
            $auth = new AuthService();
            
            
            $requestCajas->setIdUsuario($usuario['id']);

            $item = CajasRepository::create($requestCajas);
            return ["datos" => $item];
        } catch (PDOException $e) {
            throw new \Exception('Error al crear un Caja. Inténtalo más tarde.');
        }
    }

    public function getAll(): array
    {
        $items = CajasRepository::find();

        if (!$items) {
            throw new \Exception('No se encuentran Cajas.');
        }
        return $items;
    }

    public function get($request): array
    {
        $item = CajasRepository::findById($request->getId());

        if (!$item) {
            throw new \Exception('No se encuentra Cajas.');
        }
        return $item;
    }

    public function update($requestCajas, $authRequest): array
    {
        try {
            $auth = new AuthService();
            $Cajas = CajasRepository::findById($requestCajas->getId());
            $authRequest->setId($Cajas['id_usuario']);
            $requestCajas->setIdUsuario($Cajas['id_usuario']);
            if($authRequest->getClave()=='vacio'){
                $auth->updateUser($authRequest);
            }else{
                $auth->update($authRequest);
            }
            $item = CajasRepository::update($requestCajas);
            if (!$item) {
                throw new \Exception('Caja inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al modificar unn Cajas. Inténtalo más tarde.');
        }
    }

    public function delete($request): bool
    {
        try {
            $item = CajasRepository::delete($request);
            if (!$item) {
                throw new \Exception('Caja inexistente.');
            }
            return $item;
        } catch (PDOException $e) {
            throw new \Exception('Error al eliminar un Caja. Inténtalo más tarde.');
        }
    }

    public function pdfCaja($id)
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
            'numero_presupuesto' => $presupuesto['numero_presupuesto'] ?? 0000,
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
        $html =  RenderHelper::pdf(
            dirname(__DIR__,2).'/Presupuesto/Views/presupuesto.php', 
            array_merge($datos, ['tabla_materiales' => $tablaMaterialesHtml])
        );
    
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
    
        // Actualizo el id de estado a 2 que es en proceso
        $presupuesto = PresupuestosRepository::enProceso($id);

        exit; // Finalizar script para evitar cualquier salida extra
    }
}
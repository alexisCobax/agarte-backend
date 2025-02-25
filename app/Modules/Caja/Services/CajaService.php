<?php

namespace App\Modules\Caja\Services;

use PDOException;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Support\Request;
use App\Helpers\RenderHelper;
use App\Modules\Auth\Services\AuthService;
use App\Modules\Caja\Repositories\CajaRepository;
use App\Modules\Caja\Repositories\CajasRepository;
use App\Modules\Caja\Repositories\CajaDetalleRepository;

class CajaService
{
    public function create($requestCajas): array
    {
        try {
            $auth = new AuthService();
            
            
            $requestCajas->setIdUsuario($auth['id']);

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

    public function pdfCaja($request, $id)
    {
        ob_start(); // Iniciar buffer de salida para evitar problemas con headers
    
        $caja = CajaRepository::findBySucursalId($id);

        $cajaDetalle = CajaDetalleRepository::findById($request, $id);

        $totalEfectivo = array_sum(array_column($cajaDetalle["results"], "efectivo"));
        $totalTarjeta = array_sum(array_column($cajaDetalle["results"], "tarjeta"));
        $totalTransferencia = array_sum(array_column($cajaDetalle["results"], "deposito"));
        $total = $totalEfectivo+($totalTarjeta+$totalTransferencia);
        $clienteNombre = $caja['cliente_nombre'] ?? '';
        $clienteDomicilio = $caja['cliente_domicilio'] ?? '';
        $clienteTelefono = $caja['cliente_telefono'] ?? '';
        $clienteEmail = $caja['cliente_email'] ?? '';
        $nombreSucursal = $caja['nombreSucursal'] ?? '';
        $idRecibo = str_pad($caja['idRecibo'], 4, "0", STR_PAD_LEFT) ?? '';

        $datos = [
            'id_recibo'=>$idRecibo ?? '',
            'total_efectivo'=>$totalEfectivo  ?? '',
            'total_tarjeta'=>$totalTarjeta  ?? '',
            'total_transferencia'=>$totalTransferencia  ?? '',
            'total'=>$total ?? '',
            'cliente_nombre'=>$clienteNombre ?? '',
            'cliente_domicilio'=>$clienteDomicilio ?? '',
            'cliente_telefono'=>$clienteTelefono ?? '',
            'cliente_email'=>$clienteEmail ?? '',
            'nombre_sucursal'=>$nombreSucursal ?? ''
        ];
    
        // Construcción de la tabla en HTML
        $tablaCajaHtml = "";
        foreach ($cajaDetalle['results'] as $item) {
            $tablaCajaHtml .= "<tr style='border: 1px solid black;'>
                <td style='text-align:left; border: 1px solid black; width: 20px;'>" . str_pad($item['id'], 4, '0', STR_PAD_LEFT) . "</td>
                <td style='text-align:center; width:10px; border: 1px solid black;'>" . str_pad($item['orden'], 4, '0', STR_PAD_LEFT) . "</td>
                <td style='text-align:center; width:200px; border: 1px solid black;'>{$item['cliente']}</td>
                <td style='text-align:left; width:10px; border: 1px solid black;'>".'$'."{$item['efectivo']}</td>
                <td style='text-align:left; width:10px; border: 1px solid black;'>".'$'."{$item['tarjeta']}</td>
                <td style='text-align:left; width:10px; border: 1px solid black;'>".'$'."{$item['deposito']}</td>
                <td style='text-align:left; width:10px; border: 1px solid black;'>".'$'."{$item['total']}</td>
            </tr>";
        }

        $html =  RenderHelper::pdf(
            dirname(__DIR__,2).'/Caja/Views/Caja.php', 
            array_merge($datos, ['tabla_caja' => $tablaCajaHtml])
        );
    
        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
    
        $dompdf = new Dompdf($options);
        $css = file_get_contents(dirname(__DIR__,1).'/Views/css/caja.css');
        $html = "<style>$css</style>" . $html;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        ob_end_clean(); // Limpiar cualquier salida antes de enviar el PDF
        $dompdf->stream('caja.pdf', ['Attachment' => false]);

        exit; // Finalizar script para evitar cualquier salida extra
    }
}
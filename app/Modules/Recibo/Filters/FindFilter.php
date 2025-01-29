<?php

namespace App\Modules\Recibo\Filters;

use App\Helpers\UserDataHelper;

class FindFilter
{
    public static function getFilters(): array
    {
        $filters = [];
     
        
        
        if (isset($_GET['cliente'])) {
            $filters[] = " recibos.cliente_nombre LIKE " . self::SQLformat('%' . $_GET['cliente'] . '%');
        }
        if (isset($_GET['desde'])&&isset($_GET['hasta'])&&$_GET['desde']!=""&&$_GET['hasta']!="") {
            $filters[] = " recibos.fecha between " . self::SQLformat( $_GET['desde']) . " and " . self::SQLformat( $_GET['hasta']);
        }else{
            if (isset($_GET['desde'])&&$_GET['desde']!="") {
                $filters[] = " recibos.fecha >= " . self::SQLformat( $_GET['desde']);
            }
            if (isset($_GET['hasta'])&&$_GET['hasta']!="") {
                $filters[] = " recibos.fecha <= " . self::SQLformat( $_GET['hasta']);
            }
        }
        if (isset($_GET['orden'])) {
            $filters[] = " presupuestos.numero_orden  = " . self::SQLformat( $_GET['orden'] );
        }

        $user = UserDataHelper::getUserData();
        $idSucursal=  $user['id_sucursal'] ?? 0;

        if($idSucursal){
            $filters[] = " recibos.id_sucursal = " . $idSucursal;
        }


        return $filters;
    }
    

    /* 
     *Esta funcion es para cuando viene un string 
     *lo envie con comillas dobles y no de un error en la consulta
     */

    private static function SQLformat($value): string
    {
        // Verifica si el valor es un string
        if (is_string($value)) {
            return '"' . $value . '"';
        }
        // Si no es un string, lo retorna tal cual
        return $value;
    }
}

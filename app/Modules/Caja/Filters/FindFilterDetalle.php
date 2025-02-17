<?php

namespace App\Modules\Caja\Filters;
use App\Helpers\UserDataHelper;
class FindFilterDetalle
{
    public static function getFilters(): array
    {
        $filters = [];

        /* Ejemplo */
        
        if (isset($_GET['fecha'])) {
            $filters[] = "recibos.fecha = " . self::SQLformat( $_GET['fecha'] );
        }
        $filters[] = "recibos.borrado =0 ";

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

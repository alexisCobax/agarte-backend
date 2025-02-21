<?php

namespace App\Modules\OrdenDeTrabajo\Filters;

use App\Helpers\UserDataHelper;

class FindAllFilter
{
    public static function getFilters(): array
    {
        $filters = [];

           if (isset($_GET['desde'])&&isset($_GET['hasta'])&&$_GET['desde']!=""&&$_GET['hasta']!="") {
            $filters[] = " presupuestos.fecha between " . self::SQLformat( $_GET['desde']) . " and " . self::SQLformat( $_GET['hasta']);
        }else{
            if (isset($_GET['desde'])&&$_GET['desde']!="") {
                $filters[] = " presupuestos.fecha >= " . self::SQLformat( $_GET['desde']);
            }
            if (isset($_GET['hasta'])&&$_GET['hasta']!="") {
                $filters[] = " presupuestos.fecha <= " . self::SQLformat( $_GET['hasta']);
            }
        }


        if (isset($_GET['cliente'])) {
            $filters[] = " presupuestos.cliente_nombre LIKE " . self::SQLformat('%' . $_GET['cliente'] . '%');
        }

        if (isset($_GET['numero'])) {
            $filters[] = " presupuestos.numero_orden = " . self::SQLformat( $_GET['numero'] );
        }

        if (isset($_GET['estado']) && $_GET['estado'] != '') {
            $filters[] = " presupuestos.estado_orden_trabajo = " . self::SQLformat( $_GET['estado'] );
        }

        if (isset($_GET['sucursales']) && $_GET['sucursales'] != '') {
            $filters[] = " presupuestos.id_sucursal = " . self::SQLformat( $_GET['sucursales'] );
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

<?php

namespace App\Modules\Caja\Filters;

class FindFilter
{
    public static function getFilters(): array
    {
        $filters = [];

        if (isset($_GET['id_sucursal'])) {
            $filters[] = "recibos.id_sucursal = " . $_GET['id_sucursal'];
        }

        if (isset($_GET['fecha'])) {
            $filters[] = "recibos.fecha = " . $_GET['fecha'];
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

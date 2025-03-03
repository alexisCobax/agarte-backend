<?php

namespace App\Modules\ObjetosEnmarcar\Filters;

class FindFilter
{
    public static function getFilters(): array
    {
        $filters = [];
    
        if (isset($_GET['id_sucursal']) && $_GET['id_sucursal'] !== '') {
            $filters[] = "id_sucursal = " . intval($_GET['id_sucursal']);
        }

        $filters[] = "(borrado IS NULL OR borrado != 1)";
    
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

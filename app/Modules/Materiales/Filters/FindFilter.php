<?php

namespace App\Modules\Materiales\Filters;

class FindFilter
{
    public static function getFilters(): array
    {
        $filters = [];
        
        if (isset($_GET['tipo_material'])) {
            $filters[] = "id_tipo_material = " . self::SQLformat($_GET['tipo_material']);
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

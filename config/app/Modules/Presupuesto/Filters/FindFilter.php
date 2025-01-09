<?php

namespace App\Modules\Presupuesto\Filters;

class FindFilter
{
    public static function getFilters(): array
    {
        $filters = [];
 
        if (isset($_GET['id_tipo_material'])) {
            $filters[] = "materiales.id_tipo_material = " . self::SQLformat($_GET['id_tipo_material']);
        }

        if (isset($_GET['id_presupuesto'])) {
            $filters[] = "presupuestos_detalle.id_presupuesto = " . self::SQLformat($_GET['id_presupuesto']);
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

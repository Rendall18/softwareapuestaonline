<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Resultado;



class ResultadoController extends Controller
{
    public function post_resultado($dia,$mes,$ano)
    {
        $fecha=date($ano.'-'.$mes.'-'.$dia);
        $objetos=Resultado::buscar_objetos($fecha);
        //dd($objetos);
        if($objetos=='No hay resultados Disponibles')
            return $objetos;
        else
            return response()->json(Resultado::resgitrar_resultados($objetos,$fecha));
      
    }
}

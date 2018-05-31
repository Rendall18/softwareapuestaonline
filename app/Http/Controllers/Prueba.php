<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Prueba;
class Prueba extends Controller
{
    public function get_info()
    {
        date_default_timezone_set('America/Caracas');

	        $fecha_actual = date('Y-m-d');
            dd(Prueba::saber_dia_semana($fecha_actual));
			//$fecha_actual="2015-11-28";
			$fecha_ayer=strtotime("-1 day",strtotime($fecha_actual));
			$fecha2 = date('Y/m/d',$fecha_ayer);
			$fecha_actual=date("Y-m-d",$fecha_ayer);
			$dato = explode("-", $fecha_actual);
			$año=$dato[0];
			$mes=$dato[1];
			$dia=$dato[2]; 
            $html = new \Htmldom('https://www.betfair.com/sport/football?id=117&competitionEventId=259241&action=loadCompetition&modules=multipickavbId@1007&selectedTabType=COMPETITION');
            $instancia=$html->find('li[class="section"]');
            $bloques_fecha=count($instancia);   
            
            $array_fecha=array();
            $array_numero_juegos=array();
            $partidos_totales=0;
            for($j=0;$j<$bloques_fecha;$j++)
            {
                $array_fecha[$j]=$instancia[$j]->childNodes(0)->childNodes(0)->plaintext;
                $juegos=$instancia[$j]->childNodes(1)->childNodes();
                $array_numero_juegos[$j]=count($juegos);
                $partidos_totales+=count($juegos);
                echo $array_fecha[$j].'<br>';

            }
            
            $i=0;
            $array_enlaces=array();
            foreach($html->find('a') as $element) 
            {
                    $cadena_de_texto = $element->href;
                    $cadena_buscada   = '/sport/football/event?eventId=';
                    $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                    if ($posicion_coincidencia !== false)
                    {
                        $array_enlaces[$i]=$element->href;
                        $i++;
                    }
            }

            $resultado = array_unique($array_enlaces);
            $array_enlaces=array();$i=0;
            foreach($resultado as $element) 
            {
                if($i<$partidos_totales)
                {
                    $array_enlaces[$i]=$element;
                    $i++;
                }else
                    break;
            }

           /// echo print_r($array_enlaces);
    }
}

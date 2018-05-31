<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Prueba;
use Excel;

class ExcelController extends Controller
{
    public function exportarExcel(Request $request)
	{
		$monto=$request->monto;
		$dias=$request->dias;
		$tipo=$request->tipo;
		$ip=$request->ip();
        
		//$monto=5;
		$acumulador=1;
		$acumulador_simulador=1;
		$aux2=Prueba::multiplicador_loco($dias,$ip);
		$aux=array();
		$condicionador_externo=0;
		$condicionador_interno=0;
        
     
		for($i=0;$i<count($aux2['Multiplicador']);$i++)
		{
			if($i==0)
			{
				$acumulador*=$monto;
			}
				if($aux2['Multiplicador'][$i]->estado!='Aplazado')
				{
					$acumulador*=$aux2['Multiplicador'][$i]->logro;
				}
				$aux['Multiplicador'][$i]['id']=$aux2['Multiplicador'][$i]->id;
				$aux['Multiplicador'][$i]['equipo_local']=$aux2['Multiplicador'][$i]->equipo_local;
				$aux['Multiplicador'][$i]['equipo_visitante']=$aux2['Multiplicador'][$i]->equipo_visitante;
				$aux['Multiplicador'][$i]['tipo_logro']=$aux2['Multiplicador'][$i]->tipo_logro;
				$aux['Multiplicador'][$i]['logro']=$aux2['Multiplicador'][$i]->logro;
				$aux['Multiplicador'][$i]['fecha']=$aux2['Multiplicador'][$i]->fecha;
				$aux['Multiplicador'][$i]['hora']=$aux2['Multiplicador'][$i]->hora;
				$aux['Multiplicador'][$i]['estado']=$aux2['Multiplicador'][$i]->estado;
				$aux['Multiplicador'][$i]['resultado']=$aux2['Multiplicador'][$i]->resultado;
				
				if($aux2['Multiplicador'][$i]->estado=='Perdedor')
				{
					$acumulador=$monto;
				}
				$aux['Multiplicador'][$i]['acumulativo']=$acumulador;
				
		}

		if($tipo==1){
			//dd(count($aux));
			if(count($aux)<1)
				$aux['Multiplicador']=[];
			return response()->json($aux);
		}else{
			//dd($aux);
			Excel::create('Multiplicador_Loco', function($excel) use ($aux){
        		$excel->sheet('pagina1', function($sheet) use($aux) {  
        		
                 $sheet->loadView('ExportExcel',$aux);
        			});
      			})->export('xls');
		}
			
	/*
			Excel::create($date, function($excel) use ($aux2) {
				$excel->sheet('pagina1', function($sheet) use($aux2) {            
					//$sheet->fromArray($carteleraa);
					$sheet->loadView('GenericExportExcel',$aux2);
				});
			})->export('xls');	*/	
	}

	
}

<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
class Resultado extends Model
{
   public static function resgitrar_resultados($objeto,$fecha)
   {
        $nuevo=array();
        $conta=0;
            for($i=0;$i<count($objeto);$i++)
            {
                $html = new \Htmldom($objeto[$i]->enlace);

                $instancia=$html->find('section[class="club-schedule"]');
                $hijos_instancia=$instancia[0]->childNodes(1)->childNodes(0)->childNodes();
                $resultado_visitante=-1;
                $resultado_local=-1;
                                                                                    //$i
                $estatus=trim($instancia[0]->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);
                $estatus2=trim($instancia[0]->childNodes(1)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);
                if($estatus!='En Vivo')
                {   
                    if($estatus2!='PPD')
                    {                                                                     //$i
                        $resultado_local=trim($instancia[0]->childNodes(1)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(2)->childNodes(0)->plaintext);
                        $resultado_visitante=trim($instancia[0]->childNodes(1)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(2)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);                                            
                        $nuevo[$conta]['nombre_local']=$objeto[$i]->nombre_espanol;
                        $nuevo[$conta]['resultado_local']=$resultado_local;
                        $nuevo[$conta]['resultado_visitante']=$resultado_visitante;
                         $nuevo[$conta]['suspendido']=0;
                        $conta++;
                    }else
                    {
                        $nuevo[$conta]['nombre_local']=$objeto[$i]->nombre_espanol;
                        $nuevo[$conta]['suspendido']=1;
                    }
                }
                
            }
            //dd($nuevo);
            for($i=0;$i<count($nuevo);$i++)
            {
                $equipoo= DB::table('multiplicador_loco')->where([['fecha','=',$fecha],['equipo_local','=',$nuevo[$i]['nombre_local']]])->get();
                
                $estate='';
                if($nuevo[$i]['suspendido']==0)
                {
                    $result=$nuevo[$i]['resultado_local'].'-'.$nuevo[$i]['resultado_visitante'];
                    if(($equipoo[0]->tipo_logro)==0)
                    {
                        if($nuevo[$i]['resultado_local'] < $nuevo[$i]['resultado_visitante'])
                            $estate='Perdedor';
                        else
                            $estate='Ganador';
                    }elseif(($equipoo[0]->tipo_logro)==2)
                    {
                        if(((int)$nuevo[$i]['resultado_local'] + (int)$nuevo[$i]['resultado_visitante'])>6)
                            $estate='Perdedor';
                        else
                            $estate='Ganador';
                    }else
                    {
                        if(((int)$nuevo[$i]['resultado_local'] + (int)$nuevo[$i]['resultado_visitante'])==0)
                            $estate='Perdedor';
                        else
                            $estate='Ganador';
                    }
                }else{
                    $result=' - ';
                    $estate='Aplazado';
                }
                $update=DB::table('multiplicador_loco')
                ->where('id', $equipoo[0]->id)
                ->update(['estado' => $estate , 'resultado' => $result]);
            }
            return $nuevo;
   }

   public static function buscar_objetos($fecha)
   {
       
       //return  $fecha;
        $data2= DB::table('multiplicador_loco')
        ->where([['fecha','=',$fecha],['estado','=','']])->get();
        
        if(count($data2)>0)
        {       
            $equipos=array();$cont=0;
            for($i=0;$i< count($data2);$i++)
            {
                
                 $data_local= DB::table('equipos')->where('nombre_espanol','=',$data2[$i]->equipo_local)->get();
                 //$data_local= DB::table('equipos')->where('nombre_espanol','=',$data2[$i]->equipo_visitante)->get();
                if(count($data_local)>0)
                {
                    $equipos[$cont]=$data_local[0];
                    $cont++;
                }
            }
            return $equipos;
        }else{
            return 'No hay resultados Disponibles';
        }
       
   }
}

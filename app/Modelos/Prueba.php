<?php

namespace App\Modelos;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use DB;
class Prueba extends Model
{
    public static function saber_dia_semana_letra($fecha)
    {
        $dias = array('lunes','martes','miércoles','jueves','viernes','sábado','domingo');
        $dia_semana = $dias[(date('N', strtotime($fecha)))-1];
        return $dia_semana;
    }

    public static function saber_dia_semana_letra_ingles($fecha)
    {
        $dias = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
        $dia_semana = $dias[(date('N', strtotime($fecha)))-1];
        return $dia_semana;
    }

    public static function saber_mes_letra($fecha)
    {
        $meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $dato = explode("-", $fecha);
        $año=$dato[0];
        $mes=$dato[1];
        $dia=$dato[2];
        return $meses[$mes-1];
    }

    public static function saber_mes_letra_ingles($fecha)
    {
        $meses = array('January','February','March','April','May','June','July','August','September','October','November','December');
        $dato = explode("-", $fecha);
        $año=$dato[0];
        $mes=$dato[1];
        $dia=$dato[2];
        return $meses[$mes-1];
    }

    public static function saber_mes_numero($fecha)
    {
        $dato = explode("-", $fecha);
        $año=$dato[0];
        $mes=$dato[1];
        $dia=$dato[2];
        return $mes;
    }
    public static function saber_año_numero($fecha)
    {
        $dato = explode("-", $fecha);
        $año=$dato[0];
        $mes=$dato[1];
        $dia=$dato[2];
        return $año;
    }
    public static function saber_dia_numero($fecha)
    {
        $dato = explode("-", $fecha);
        $año=$dato[0];
        $mes=$dato[1];
        $dia=$dato[2];
        $dia = intval($dia);
        $dia=sprintf('%02d', $dia); 
        return $dia;
    }

    public static function fecha_bd($fecha)
    {
        $fecha_actual= date('Y-m-d');
        $dato2 = explode("-", $fecha_actual);
        $año=$dato2[0];
        //dd($año);
         //jueves 7 de diciembre de 2017 
         $meses=array('enero'=>'01','febrero'=>'02','marzo'=>'03','abril'=>'04','mayo'=>'05','junio'=>'06',
                    'julio'=>'07','agosto'=>'08','septiembre'=>'09','octubre'=>'10','noviembre'=>'11',
                    'diciembre'=>'12');
        
        $fecha=trim($fecha);
        $dato = explode(" ", $fecha);
        //dd($dato);
        //$dias=$dato[1];
        //$datas = explode(" ", $dias);
        $dia=$dato[1];
        $mes=$meses[$dato[2]];
        
        $fecha_r=$año.'-'.$mes.'-'.sprintf("%02d", $dia);
        //dd($fecha_r);
        return $fecha_r;
    }

    public static function buscar_objeto_resultado($equipo)
    {
        //echo 'equipo : '.$equipo.'<br>';
        $equipo=trim($equipo);
         $data= DB::table('equipos')->where('nombre_espanol','=',$equipo)->get();
         if(empty($data))
            return 'nombre no encontrado';
         else
            return  $data;
    }

    public static function buscar_numero($numero)
    {
        
        // $data= DB::table('equipos')->where('nombre_espanol','=',$equipo)->get();
         $data = DB::table('equipos')->skip(0)->take($numero)->get();
         if(empty($data))
            return 'nombre no encontrado';
         else
            return  $data;
    }

    public static function pp($competencia,$enlace,$nombre_equipo,$bandera)
    {   
            $objeto_retorno=array();
            $_goles=array();
            $_goles_local=array();
            $_goles_visitante=array();
            $_historial=array();
            $_condiciones=array();
            $_media_return=0;
            $cont=0;
            $contador=0;
            $condicion=0;
            $cont_empate=0;
            $cont_cercero=0;
            //echo 'enlace MODELO: '.$enlace.'<br>';
            $html = new \Htmldom($enlace);

                $instancia=$html->find('section[class="club-schedule"]');
                $hijos_instancia=$instancia[0]->childNodes(1)->childNodes(0)->childNodes();
                $resultado_visitante=-1;
                $resultado_local=-1;
                //echo 'Equipo: '.$numero_filas[$y]->nombre_espanol.' -> ';
                $array_un=array();
                for($i=0;$i<count($hijos_instancia);$i++)
                {     
                    $estatus=trim($instancia[0]->childNodes(1)->childNodes(0)->childNodes($i)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);
                    $ligaa=trim($instancia[0]->childNodes(1)->childNodes(0)->childNodes($i)->childNodes(1)->childNodes(0)->childNodes(0)->plaintext);
                    //echo 'competencia :'.$ligaa.'; ';
                    if($estatus=='F') //para agarrar solo los partidos finalizados
                    {     
                        if($ligaa==$competencia)
                        {
                            
                            $nombre_local=trim($instancia[0]->childNodes(1)->childNodes(0)->childNodes($i)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(1)->plaintext);            
                            $nombre_visitante=trim($instancia[0]->childNodes(1)->childNodes(0)->childNodes($i)->childNodes(0)->childNodes(0)->childNodes(2)->childNodes(0)->childNodes(2)->childNodes(1)->childNodes(0)->childNodes(1)->childNodes(1)->plaintext);
                            $_goles_local=(int)$instancia[0]->childNodes(1)->childNodes(0)->childNodes($i)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(2)->childNodes(0)->plaintext;
                            $_goles_visitante=(int)$instancia[0]->childNodes(1)->childNodes(0)->childNodes($i)->childNodes(0)->childNodes(0)->childNodes(2)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext;                        
                            $array_un[$contador]['nombre_local']=$nombre_local;
                            $array_un[$contador]['nombre_visitante']=$nombre_visitante;
                            $array_un[$contador]['_goles_local']=$_goles_local;
                            $array_un[$contador]['_goles_visitante']=$_goles_visitante;

                            /*--------------------Estado del Partido---------------------*/
                            if(($_goles_local>$_goles_visitante)&&($nombre_local==$nombre_equipo))
                                $array_un[$contador]['estado']='Ganador';
                            if(($_goles_local==$_goles_visitante)&&($nombre_local==$nombre_equipo))
                                $array_un[$contador]['estado']='Empate';
                            if(($_goles_local<$_goles_visitante)&&($nombre_local==$nombre_equipo))
                                $array_un[$contador]['estado']='Perdedor';
                            
                            if(($_goles_local<$_goles_visitante)&&($nombre_visitante==$nombre_equipo))
                                $array_un[$contador]['estado']='Ganador';
                            if(($_goles_local==$_goles_visitante)&&($nombre_visitante==$nombre_equipo))
                                $array_un[$contador]['estado']='Empate';
                            if(($_goles_local>$_goles_visitante)&&($nombre_visitante==$nombre_equipo))
                                $array_un[$contador]['estado']='Perdedor';
                            /*-----------------------------------------------------------*/
                            $contador++;
                        }
                    } 
                    if(count($array_un)==3)
                        break;
                }

               // dd($array_un);
            
                $band=0;
                for($k=0;$k<count($array_un);$k++)
                { 
                    if($k==0)
                    {   
                        if(!isset($array_un[$k]['estado']))
                        {
                            echo 'Nombre equipo parametro: '.$nombre_equipo;
                            dd($array_un[$k]);
                        }
                        if($array_un[$k]['estado']=='Ganador')
                        {
                            $_condiciones['item1'][$k]=false; $_condiciones['item2'][$k]=false;
                            $_condiciones['item3'][$k]=false; $_condiciones['item4'][$k]=false;
                            $_condiciones['item5'][$k]=false; $_condiciones['item6'][$k]=false;
                            $_condiciones['item7'][$k]=false;
                        }
                        if($array_un[$k]['estado']=='Empate')
                        {
                            $_condiciones['item1'][$k]=true; $_condiciones['item2'][$k]=true;
                            $_condiciones['item3'][$k]=true; 
                            if($array_un[$k]['_goles_local']==0)//como es empate el partido quedo 0-0
                                $_condiciones['item4'][$k]=true;
                            else
                                $_condiciones['item4'][$k]=false;
                            $_condiciones['item5'][$k]=false; $_condiciones['item6'][$k]=false;
                            $_condiciones['item7'][$k]=true;
                        }
                        if($array_un[$k]['estado']=='Perdedor')
                        {
                            $_condiciones['item1'][$k]=true; $_condiciones['item2'][$k]=true;
                            $_condiciones['item3'][$k]=false; $_condiciones['item4'][$k]=false;
                            $_condiciones['item5'][$k]=true; $_condiciones['item6'][$k]=true;
                            $_condiciones['item7'][$k]=true;
                        }
                    }
                    if($k==1)
                    {
                        if($array_un[$k]['estado']=='Ganador')
                        {
                            $_condiciones['item1'][$k]=false; $_condiciones['item2'][$k]=false;
                            $_condiciones['item3'][$k]=false; $_condiciones['item4'][$k]=true;
                            $_condiciones['item5'][$k]=true; $_condiciones['item6'][$k]=false;
                            $_condiciones['item7'][$k]=true;
                        }
                        if($array_un[$k]['estado']=='Empate')
                        {
                            $_condiciones['item1'][$k]=true; $_condiciones['item2'][$k]=true;
                            $_condiciones['item3'][$k]=true; $_condiciones['item4'][$k]=true;
                            $_condiciones['item5'][$k]=true; $_condiciones['item6'][$k]=false;
                            $_condiciones['item7'][$k]=true;
                        }
                        if($array_un[$k]['estado']=='Perdedor')
                        {
                            $_condiciones['item1'][$k]=true; $_condiciones['item2'][$k]=true;
                            $_condiciones['item3'][$k]=false; $_condiciones['item4'][$k]=true;
                            $_condiciones['item5'][$k]=true; $_condiciones['item6'][$k]=true;
                            $_condiciones['item7'][$k]=true;
                        }
                    }
                    if($k==2)
                    {
                        if($array_un[$k]['estado']=='Ganador')
                        {
                            $_condiciones['item1'][$k]=false; $_condiciones['item2'][$k]=true;
                            $_condiciones['item3'][$k]=true; $_condiciones['item4'][$k]=true;
                            $_condiciones['item5'][$k]=true; $_condiciones['item6'][$k]=true;
                            $_condiciones['item7'][$k]=true;
                        }
                        if($array_un[$k]['estado']=='Empate')
                        {
                            $_condiciones['item1'][$k]=true; $_condiciones['item2'][$k]=true;
                            $_condiciones['item3'][$k]=true; $_condiciones['item4'][$k]=true;
                            $_condiciones['item5'][$k]=true; $_condiciones['item6'][$k]=true;
                            $_condiciones['item7'][$k]=true;
                        }
                        if($array_un[$k]['estado']=='Perdedor')
                        {
                            $_condiciones['item1'][$k]=true; $_condiciones['item2'][$k]=true;
                            $_condiciones['item3'][$k]=true; $_condiciones['item4'][$k]=true;
                            $_condiciones['item5'][$k]=true; $_condiciones['item6'][$k]=true;
                            $_condiciones['item7'][$k]=true;
                        }
                    }
                }
                //dd($_condiciones);
                /*if($enlace=='http://www.espn.com.ve/futbol/equipo/_/id/86/real-madrid'){
                    dd($_condiciones);
                }*/
                
                
                if(count($_condiciones)>0)
                {
                    if(count($_condiciones['item1'])>0)
                    {
                        if(count($_condiciones['item1'])==3)
                        {
                            if(($_condiciones['item1'][0]==true)||($_condiciones['item1'][1]==true)||($_condiciones['item1'][2]==true))
                                $objeto_retorno['ultimos_tres_partidos_empata_o_pierde']=true;
                            else
                                $objeto_retorno['ultimos_tres_partidos_empata_o_pierde']=false;
                        }else
                            $objeto_retorno['ultimos_tres_partidos_empata_o_pierde']=false;
                    }
                    if(count($_condiciones['item2'])>0)
                    {
                        if(count($_condiciones['item2'])==3)
                        {
                            if(($_condiciones['item2'][0]==true)&&($_condiciones['item2'][1]==true)&&($_condiciones['item2'][2]==true))
                                $objeto_retorno['ultimos_dos_partidos_no_ganados']=true;
                            else
                                $objeto_retorno['ultimos_dos_partidos_no_ganados']=false;
                        }elseif(count($_condiciones['item2'])==2)
                        {
                            if(($_condiciones['item2'][0]==true)&&($_condiciones['item2'][1]==true))
                                $objeto_retorno['ultimos_dos_partidos_no_ganados']=true;
                            else
                                $objeto_retorno['ultimos_dos_partidos_no_ganados']=false;
                        }else
                            $objeto_retorno['ultimos_dos_partidos_no_ganados']=false;
                    }
                    if(count($_condiciones['item3'])>0)
                    {
                        if(count($_condiciones['item3'])==3)
                        {
                            if(($_condiciones['item3'][0]==true)&&($_condiciones['item3'][1]==true)&&($_condiciones['item3'][2]==true))
                                $objeto_retorno['ultimos_dos_partidos_empate']=true;
                            else
                                $objeto_retorno['ultimos_dos_partidos_empate']=false;
                        }elseif(count($_condiciones['item3'])==2)
                        {
                            if(($_condiciones['item3'][0]==true)&&($_condiciones['item3'][1]==true))
                                $objeto_retorno['ultimos_dos_partidos_empate']=true;
                            else
                                $objeto_retorno['ultimos_dos_partidos_empate']=false;
                        }else
                            $objeto_retorno['ultimos_dos_partidos_empate']=false;
                    }
                    if(count($_condiciones['item4'])>0)
                    {
                        if(count($_condiciones['item4'])==3)
                        {
                            if(($_condiciones['item4'][0]==true)&&($_condiciones['item4'][1]==true)&&($_condiciones['item4'][2]==true))
                                $objeto_retorno['ultimo_partido_cero_cero']=true;
                            else
                                $objeto_retorno['ultimo_partido_cero_cero']=false;
                        }elseif(count($_condiciones['item4'])==2)
                        {
                            if(($_condiciones['item4'][0]==true)&&($_condiciones['item4'][1]==true))
                                $objeto_retorno['ultimo_partido_cero_cero']=true;
                            else
                                $objeto_retorno['ultimo_partido_cero_cero']=false;
                        }else
                        {
                            if($_condiciones['item4'][0]==true)
                                $objeto_retorno['ultimo_partido_cero_cero']=true;
                            else
                                $objeto_retorno['ultimo_partido_cero_cero']=false;
                        }
                           
                    }
                    if(count($_condiciones['item5'])>0)
                    {
                        if(count($_condiciones['item5'])==3)
                        {
                            if(($_condiciones['item5'][0]==true)&&($_condiciones['item5'][1]==true)&&($_condiciones['item5'][2]==true))
                                $objeto_retorno['ultimo_partido_derrota']=true;
                            else
                                $objeto_retorno['ultimo_partido_derrota']=false;
                        }elseif(count($_condiciones['item5'])==2)
                        {
                            if(($_condiciones['item5'][0]==true)&&($_condiciones['item5'][1]==true))
                                $objeto_retorno['ultimo_partido_derrota']=true;
                            else
                                $objeto_retorno['ultimo_partido_derrota']=false;
                        }else
                        {
                            if($_condiciones['item5'][0]==true)
                                $objeto_retorno['ultimo_partido_derrota']=true;
                            else
                                $objeto_retorno['ultimo_partido_derrota']=false;
                        }
                    }
                    if(count($_condiciones['item6'])>0)
                    {
                        if(count($_condiciones['item6'])==3)
                        {
                            if(($_condiciones['item6'][0]==true)&&($_condiciones['item6'][1]==true)&&($_condiciones['item6'][2]==true))
                                $objeto_retorno['ultimos_dos_partidos_derrota']=true;
                            else
                                $objeto_retorno['ultimos_dos_partidos_derrota']=false;
                        }elseif(count($_condiciones['item6'])==2)
                        {
                            if(($_condiciones['item6'][0]==true)&&($_condiciones['item6'][1]==true))
                                $objeto_retorno['ultimos_dos_partidos_derrota']=true;
                            else
                                $objeto_retorno['ultimos_dos_partidos_derrota']=false;
                        }else
                            $objeto_retorno['ultimos_dos_partidos_derrota']=false;
                    }
                    if(count($_condiciones['item7'])>0)
                    {
                        if(count($_condiciones['item7'])==3)
                        {
                            if(($_condiciones['item7'][0]==true)&&($_condiciones['item7'][1]==true)&&($_condiciones['item7'][2]==true))
                                $objeto_retorno['ultimo_partido_no_ganado']=true;
                            else
                                $objeto_retorno['ultimo_partido_no_ganado']=false;
                        }elseif(count($_condiciones['item7'])==2)
                        {
                            if(($_condiciones['item7'][0]==true)&&($_condiciones['item7'][1]==true))
                                $objeto_retorno['ultimo_partido_no_ganado']=true;
                            else
                                $objeto_retorno['ultimo_partido_no_ganado']=false;
                        }else
                        {
                            if($_condiciones['item7'][0]==true)
                                $objeto_retorno['ultimo_partido_no_ganado']=true;
                            else
                                $objeto_retorno['ultimo_partido_no_ganado']=false;
                        }
                    }
                }else
                {
                    $objeto_retorno['ultimos_tres_partidos_empata_o_pierde']=false;
                    $objeto_retorno['ultimos_dos_partidos_no_ganados']=false;
                    $objeto_retorno['ultimos_dos_partidos_empate']=false;
                    $objeto_retorno['ultimo_partido_cero_cero']=false;
                    $objeto_retorno['ultimo_partido_derrota']=false;
                    $objeto_retorno['ultimos_dos_partidos_derrota']=false;
                     
                    $objeto_retorno['ultimo_partido_no_ganado']=false;

                    
                }

                $porciones = explode("equipo", $enlace);
                $enlace_estadistica=$porciones[0].'equipo/estadisticas'.$porciones[1];
               // dd($enlace_estadistica);
                $html = new \Htmldom($enlace_estadistica);

                $instancia=$html->find('div[class="mod-content"]');
                if($bandera==0)
                    $media=$instancia[0]->childNodes(0)->childNodes(2)->childNodes(8)->plaintext;//media como local
                else
                    $media=$instancia[0]->childNodes(0)->childNodes(3)->childNodes(8)->plaintext;//media como visitante
               
                $objeto_retorno['media_gol']=$media;

                //dd($objeto_retorno);
                return $objeto_retorno;
                
            
    }

    public static function apocalipsis($datos)
    {
        $resp=array();
       // $resp=limpiar_datos($datos);
        $arr_todo=array();
        $incr=0;
        for($hj=0;$hj<count($datos);$hj++)
        {
            for($p=0;$p<count($datos[$hj]);$p++)
            {
                $arr_todo[$incr]=$datos[$hj][$p];
                $incr++;
            }
        }
        $arr_dos=array_unique($arr_todo, SORT_REGULAR);
        $datos=array();$ui=0;
        foreach($arr_dos as $element) 
        {
            $datos[$ui]=$element;
            $ui++;
        }

        //dd($arrr_ult);

        $aray_union=array();
       // $aray_union['datos_entrada']=$datos;
        $fecha_actual=date('Y-m-d');
        $apoca=array();
        $rendimiento_garantizado=array();
        $mult_loco=array();
        $robin_hood=array();
        $senora_soltera=array();
        $cont_mul=0;
        $cont_ab=0;
        $cont_cde=0;
        $cont=0;
        $cont_rendimiento=0;
        $robin_cont=0;$ip=0;
        $con_senora=0;
        /*for($yu=0;$yu<count($array_auxx);$yu++)
        {
            foreach($array_auxx[$yu] as $element) 
            {
                $datos[$yu][$ip]=$element;
                $ip++;
            }
            $ip=0;
        }*/
        //dd($datos);
        for($h=0;$h<count($datos);$h++)
        {
            //for($i=0;$i<count($datos[$h]);$i++)
            //{
                 
                    /*Apocalipsis*/
                     //Partidos A y B
                    if(isset($datos[$h]['logros']['logro_1X']))
                    {
                        if(((((float)$datos[$h]['logros']['logro_1X'])>=2.8) && (((float)$datos[$h]['logros']['logro_1X'])<=5)) && ((((float)$datos[$h]['visitante']['media_gol'])<=3)&&(((float)$datos[$h]['visitante']['media_gol'])>=1.5)))
                        {
                            $apoca[$cont]=$datos[$h];
                            $apoca[$cont]['tipo']='partidosSafe';
                            $cont++;
                        }
                    }
                    //Partidos C y D
                    if(isset($datos[$h]['visitante']['media_gol']))
                    {
                        if( ((((float)$datos[$h]['logros']['logro_1'])>=1.2)&&(((float)$datos[$h]['logros']['logro_1'])<=1.45)) && ((((float)$datos[$h]['visitante']['media_gol'])*2)<=((float)$datos[$h]['local']['media_gol'])) && (($datos[$h]['local']['ultimos_tres_partidos_empata_o_pierde'])==true))
                        {
                       
                            if((((float)$datos[$h]['visitante']['media_gol'])>0)&&(((float)$datos[$h]['local']['media_gol'])>0))
                            {
                                $apoca[$cont]=$datos[$h];
                                $apoca[$cont]['tipo']='partidosDream';
                                
                                $cont++;
                            }
                        }
                    }
                    //Partidos E
                    if(isset($datos[$h]['logros']['logro_1X']) && isset($datos[$h]['visitante']['media_gol']) && isset($datos[$h]['local']['media_gol']) && isset($datos[$h]['local']['ultimos_dos_partidos_no_ganados']))
                    {
                        if( ((((float)$datos[$h]['logros']['logro_1X'])>=1.25)&&(((float)$datos[$h]['logros']['logro_1X'])<=1.45)) && ((((float)$datos[$h]['visitante']['media_gol'])*2)<=((float)$datos[$h]['local']['media_gol'])) && (($datos[$h]['local']['ultimos_dos_partidos_no_ganados'])==true))
                        {
                            if((((float)$datos[$h]['visitante']['media_gol'])>0) && (((float)$datos[$h]['local']['media_gol'])>0))
                            {
                                $apoca[$cont]=$datos[$h];
                                $apoca[$cont]['tipo']='partidosE';
                                $cont++;
                            }
                        }
                    }

                    /*Multiplicador Loco*/
                    if((isset($datos[$h]['logros']['logro_1X'])) && (isset($datos[$h]['logros']['over'])) && (isset($datos[$h]['logros']['menos_6_5_goles'])))
                    {
                        if((((float)$datos[$h]['logros']['logro_1X'])>=1.04) && (((float)$datos[$h]['logros']['logro_1X'])<=1.06))
                        {
                            $mult_loco[$cont_mul]=$datos[$h];
                            $mult_loco[$cont_mul]['tipo_logro']=0;
                            $mult_loco[$cont_mul]['logro']=(float)$datos[$h]['logros']['logro_1X'];
                            $cont_mul++;
                        }elseif((((float)$datos[$h]['logros']['over'])>=1.04) && (((float)$datos[$h]['logros']['over'])<=1.06) && ( (((float)$datos[$h]['logros']['logro_1'])>=1.05) && (((float)$datos[$h]['logros']['logro_1'])<=1.9)) && ((float)$datos[$h]['local']['media_gol']>=2))
                        {
                            //( ((float)$datos[$h]['logros']['over']>=1.04)&&((float)$datos[$h]['logros']['over']<=1.06)&&((float)$datos[$h]['local']['ultimo_partido_cero_cero']==true || (float)$datos[$h]['visitante']['ultimo_partido_cero_cero']==true))
                            $mult_loco[$cont_mul]=$datos[$h];
                            $mult_loco[$cont_mul]['tipo_logro']=1;
                            $mult_loco[$cont_mul]['logro']=(float)$datos[$h]['logros']['over'];
                            $cont_mul++;
                        }elseif((((float)$datos[$h]['logros']['menos_6_5_goles'])>=1.04) && (((float)$datos[$h]['logros']['menos_6_5_goles'])<=1.06))
                        {
                            $mult_loco[$cont_mul]=$datos[$h];
                            $mult_loco[$cont_mul]['tipo_logro']=2;
                            $mult_loco[$cont_mul]['logro']=(float)$datos[$h]['logros']['menos_6_5_goles'];
                            $cont_mul++;
                        }else{
                            $tg=0;
                        }
                    }
                    
                    /*Robin Hood*/
                    //Partidos A
                    if(isset($datos[$h]['logros']['logro_1X']) && isset($datos[$h]['logros']['logro_2']))
                    {
                        if(((((float)$datos[$h]['logros']['logro_1X'])>=1.65)) && (((float)$datos[$h]['logros']['logro_2'])>=2))
                        {
                            $robin_hood[$robin_cont]=$datos[$h];
                            $robin_hood[$robin_cont]['tipo']='partidosA';
                            $robin_cont++;
                        }
                    }
                    //Partidos B
                    
                    if(isset($datos[$h]['logros']['logro_1']) && isset($datos[$h]['visitante']['media_gol']) && isset($datos[$h]['local']['media_gol']))
                    {
                        if(((((float)$datos[$h]['logros']['logro_1'])>=1.30) && (((float)$datos[$h]['logros']['logro_1'])<=1.4)) && ((((float)$datos[$h]['visitante']['media_gol'])*2)<=((float)$datos[$h]['local']['media_gol'])))
                        {
                            if((((float)$datos[$h]['visitante']['media_gol'])>0) && (((float)$datos[$h]['local']['media_gol'])>0))
                            {
                                $robin_hood[$robin_cont]=$datos[$h];
                                $robin_hood[$robin_cont]['tipo']='partidosB';
                                $robin_cont++;
                            }
                        }
                    
                        //Partidos C
                        if(((((float)$datos[$h]['logros']['logro_1'])>=1.20) && (((float)$datos[$h]['logros']['logro_1'])<=1.30)) && ((((float)$datos[$h]['visitante']['media_gol'])*2)<=((float)$datos[$h]['local']['media_gol'])))
                        {
                            if((((float)$datos[$h]['visitante']['media_gol'])>0) && (((float)$datos[$h]['local']['media_gol'])>0))
                            {
                               // dd($datos[$h]);
                                $robin_hood[$robin_cont]=$datos[$h];
                                $robin_hood[$robin_cont]['tipo']='partidosC';
                                $robin_cont++;
                            }
                        }
                        //Partidos D
                        if(((((float)$datos[$h]['logros']['logro_1X'])>=1.10) && (((float)$datos[$h]['logros']['logro_1X'])<=1.20)) && ((((float)$datos[$h]['visitante']['media_gol'])*2)<=((float)$datos[$h]['local']['media_gol'])))
                        {
                            if((((float)$datos[$h]['visitante']['media_gol'])>0) && (((float)$datos[$h]['local']['media_gol'])>0))
                            {
                                $robin_hood[$robin_cont]=$datos[$h];
                                $robin_hood[$robin_cont]['tipo']='partidosD';
                                $robin_cont++;
                            }
                        } 
                    
                        //Partidos E
                        if(isset($datos[$h]['local']['ultimo_partido_no_ganado']) || isset($datos[$h]['visitante']['ultimo_partido_no_ganado']))
                        {
                            if(((((float)$datos[$h]['logros']['logro_1'])>=3.3) && (((float)$datos[$h]['logros']['logro_1'])<=3.8)) && (((float)$datos[$h]['local']['media_gol'])>0) && (((float)$datos[$h]['local']['media_gol'])<=2) && (($datos[$h]['local']['ultimo_partido_no_ganado'])==true || ($datos[$h]['visitante']['ultimo_partido_no_ganado'])==true))
                            {
                                $robin_hood[$robin_cont]=$datos[$h];
                                $robin_hood[$robin_cont]['tipo']='partidosE';
                                $robin_cont++;
                            }
                        }
                    }
                    if(isset($datos[$h]['logros']['logro_1X']) && isset($datos[$h]['visitante']['media_gol']))
                    {
                        if(((((float)($datos[$h]['logros']['logro_1X']))>=3)&&(((float)($datos[$h]['logros']['logro_1X']))<=4)) && (((float)$datos[$h]['visitante']['media_gol'])<=3))
                        {
                            //dd($datos[$h]);
                            $senora_soltera[$con_senora]=$datos[$h];
                            $senora_soltera[$con_senora]['tipo']='partidosA';
                            $con_senora++;
                        }
                    }
                    if(isset($datos[$h]['logros']['logro_X']) && isset($datos[$h]['local']['media_gol']) && isset($datos[$h]['visitante']['media_gol']))
                    {
                        if(((((float)($datos[$h]['logros']['logro_X']))>=3)&&(((float)($datos[$h]['logros']['logro_X']))<=3.6)) && (((float)$datos[$h]['visitante']['media_gol'])<=3) && (((float)$datos[$h]['local']['media_gol'])<=3))
                        {
                            $senora_soltera[$con_senora]=$datos[$h];
                            $senora_soltera[$con_senora]['tipo']='partidosB';
                            $con_senora++;
                        }
                    }
            //}
        }
       // dd($mult_loco);
       $aray_union['Apocalipsis']=$apoca;
       $aray_union['Multiplicador']=$mult_loco;
       $aray_union['Robin_Hood']=$robin_hood;
       $aray_union['Senora_Soltera']=$senora_soltera;
       // dd($aray_union);

       $apoca2=array_unique($apoca, SORT_REGULAR);
       $apoca_ult=array();$ij=0;
       foreach($apoca2 as $element) 
        {
            $apoca_ult[$ij]=$element;
            $ij++;
        }

        $mult_loco2=array_unique($mult_loco, SORT_REGULAR);
        $mult_loco_ult=array();$ijp=0;
       foreach($mult_loco2 as $element) 
        {
            $mult_loco_ult[$ijp]=$element;
            $ijp++;
        }
        //dd($mult_loco_ult);
       $robin_h=array_unique($robin_hood, SORT_REGULAR);
       $robin_hood2=array();$io=0;
       foreach($robin_h as $element) 
        {
            $robin_hood2[$io]=$element;
            $io++;
        }

        $senora_solt=array_unique($senora_soltera, SORT_REGULAR);
        $senora_soltera2=array();$ss=0;
        foreach($senora_solt as $element) 
        {
            $senora_soltera2[$ss]=$element;
            $ss++;
        }

      //dd($apoca_ult);
        $ret='';
        for($k=0;$k<count($apoca_ult);$k++)
        {
            DB::table('apocalipsis')
            ->where([
                        ['equipo1', '=', $apoca_ult[$k]['equipo1']],
                        ['equipo2', '=', $apoca_ult[$k]['equipo2']]
                    ])
            ->whereBetween('fecha', [$fecha_actual, date('Y-m-d',strtotime("+7 day",strtotime($fecha_actual)))])
            ->update(['estado' => 0]);
        }
        for($k=0;$k<count($apoca_ult);$k++)
        {
             
                    $ret=DB::table('apocalipsis')->insert(
                        [
                            'equipo1' => $apoca_ult[$k]['equipo1'],
                            'equipo2' => $apoca_ult[$k]['equipo2'],
                            'media_gol_local' => $apoca_ult[$k]['local']['media_gol'],
                            'media_gol_visitante' => $apoca_ult[$k]['visitante']['media_gol'],
                            'tipo' => $apoca_ult[$k]['tipo'],
                            'fecha' => $apoca_ult[$k]['fecha'],
                            'hora' => '00:00:00',// $apoca_ult[$k]['hora'],
                            'estado' => 1,
                            'logro_1x' => $apoca_ult[$k]['logros']['logro_1X'],
                            'logro_1' => $apoca_ult[$k]['logros']['logro_1'],
                            'logro_x' => $apoca_ult[$k]['logros']['logro_X'],
                            'logro_2' => $apoca_ult[$k]['logros']['logro_2'],
                            'logro_0_a_1' => $apoca_ult[$k]['logros']['logro_0_1'],
                            'logro_0_a_2' => $apoca_ult[$k]['logros']['logro_0_2'],
                            'logro_1_a_2' => $apoca_ult[$k]['logros']['logro_1_2'],
                            'logro_0_a_3' => $apoca_ult[$k]['logros']['logro_0_3'],
                            'logro_1_a_3' => $apoca_ult[$k]['logros']['logro_1_3'],
                            'logro_2_a_3' => $apoca_ult[$k]['logros']['logro_2_3'],
                            'logro_menos_6_5_goles' => $apoca_ult[$k]['logros']['menos_6_5_goles'],
                            'logro_over_0_5' => $apoca_ult[$k]['logros']['over'],
                            'logro_over_3_5' => $apoca_ult[$k]['logros']['over_3_5']
                        ]);
            
        }
        $fecha_sigg=strtotime("-1 day",strtotime($fecha_actual));
        for($k=0;$k<count($mult_loco_ult);$k++)
        {
            /* $data2= DB::table('multiplicador_loco')->where([
                                                        ['equipo_local','=',$mult_loco_ult[$k]['equipo1']],
                                                        ['equipo_visitante','=',$mult_loco_ult[$k]['equipo2']],
                                                        ['fecha','=',$mult_loco_ult[$k]['fecha']]
                                                    ])->get();*/
                
            $data2=DB::table('multiplicador_loco')
            ->where([
                        ['equipo_local','=',$mult_loco_ult[$k]['equipo1']],
                        ['equipo_visitante','=',$mult_loco_ult[$k]['equipo2']]
                    ])
                    ->whereBetween('fecha', [$fecha_actual, date('Y-m-d',strtotime("+7 day",strtotime($fecha_actual)))])
            ->delete();
        
            /*if(count($data2)>0)
            {
                $ffff=0;
            }else{*/
                    $ret=DB::table('multiplicador_loco')->insert([
                                                    'equipo_local' => $mult_loco_ult[$k]['equipo1'],
                                                    'equipo_visitante' => $mult_loco_ult[$k]['equipo2'],
                                                    'tipo_logro' => $mult_loco_ult[$k]['tipo_logro'],
                                                     'logro' => $mult_loco_ult[$k]['logro'],
                                                    'fecha' => $mult_loco_ult[$k]['fecha'],
                                                    'hora' => '00:00:00',// $mult_loco_ult[$k]['hora'],
                                                    'estado' => '',
                                                    'resultado' => '',
                                                    'acumulativo' => ''
                                                    
                                                  ]);
               // }
        
        }
        for($k=0;$k<count($robin_hood2);$k++)
        {
            DB::table('robin_hood')
            ->where([
                        ['equipo1', '=', $robin_hood2[$k]['equipo1']],
                        ['equipo2', '=', $robin_hood2[$k]['equipo2']]
                    ])
            ->whereBetween('fecha', [$fecha_actual, date('Y-m-d',strtotime("+7 day",strtotime($fecha_actual)))])
            ->update(['estado' => 0]);
        }
        for($k=0;$k<count($robin_hood2);$k++)
        {
             
                    $ret=DB::table('robin_hood')->insert(
                        [
                            'equipo1' => $robin_hood2[$k]['equipo1'],
                            'equipo2' => $robin_hood2[$k]['equipo2'],
                            'media_gol_local' => $robin_hood2[$k]['local']['media_gol'],
                            'media_gol_visitante' => $robin_hood2[$k]['visitante']['media_gol'],
                            'tipo' => $robin_hood2[$k]['tipo'],
                            'fecha' => $robin_hood2[$k]['fecha'],
                            'hora' => '00:00:00',// $robin_hood2[$k]['hora'],
                            'estado' => 1,
                            'logro_1x' => $robin_hood2[$k]['logros']['logro_1X'],
                            'logro_1' => $robin_hood2[$k]['logros']['logro_1'],
                            'logro_x' => $robin_hood2[$k]['logros']['logro_X'],
                            'logro_2' => $robin_hood2[$k]['logros']['logro_2'],
                            'logro_0_a_1' => $robin_hood2[$k]['logros']['logro_0_1'],
                            'logro_0_a_2' => $robin_hood2[$k]['logros']['logro_0_2'],
                            'logro_1_a_2' => $robin_hood2[$k]['logros']['logro_1_2'],
                            'logro_0_a_3' => $robin_hood2[$k]['logros']['logro_0_3'],
                            'logro_1_a_3' => $robin_hood2[$k]['logros']['logro_1_3'],
                            'logro_2_a_3' => $robin_hood2[$k]['logros']['logro_2_3'],
                            'logro_menos_6_5_goles' => $robin_hood2[$k]['logros']['menos_6_5_goles'],
                            'logro_over_0_5' => $robin_hood2[$k]['logros']['over'],
                            'logro_over_3_5' => $robin_hood2[$k]['logros']['over_3_5']
                        ]);
            
        }
        for($kp=0;$kp<count($senora_soltera2);$kp++)
        {
            DB::table('senora_soltera')
            ->where([
                        ['equipo1', '=', $senora_soltera2[$kp]['equipo1']],
                        ['equipo2', '=', $senora_soltera2[$kp]['equipo2']]
                    ])
            ->whereBetween('fecha', [$fecha_actual, date('Y-m-d',strtotime("+7 day",strtotime($fecha_actual)))])
            ->update(['estado' => 0]);
        }
        for($kp=0;$kp<count($senora_soltera2);$kp++)
        {
            $ret=DB::table('senora_soltera')->insert(
            [
                'equipo1' => $senora_soltera2[$kp]['equipo1'],
                'equipo2' => $senora_soltera2[$kp]['equipo2'],
                'media_gol_local' => $senora_soltera2[$kp]['local']['media_gol'],
                'media_gol_visitante' => $senora_soltera2[$kp]['visitante']['media_gol'],
                'tipo' => $senora_soltera2[$kp]['tipo'],
                'fecha' => $senora_soltera2[$kp]['fecha'],
                'hora' => '00:00:00',// $senora_soltera2[$kp]['hora'],
                'estado' => 1,
                'logro_1x' => $senora_soltera2[$kp]['logros']['logro_1X'],
                'logro_1' => $senora_soltera2[$kp]['logros']['logro_1'],
                'logro_x' => $senora_soltera2[$kp]['logros']['logro_X'],
                'logro_2' => $senora_soltera2[$kp]['logros']['logro_2'],
                'logro_0_a_1' => $senora_soltera2[$kp]['logros']['logro_0_1'],
                'logro_0_a_2' => $senora_soltera2[$kp]['logros']['logro_0_2'],
                'logro_1_a_2' => $senora_soltera2[$kp]['logros']['logro_1_2'],
                'logro_0_a_3' => $senora_soltera2[$kp]['logros']['logro_0_3'],
                'logro_1_a_3' => $senora_soltera2[$kp]['logros']['logro_1_3'],
                'logro_2_a_3' => $senora_soltera2[$kp]['logros']['logro_2_3'],
                'logro_menos_6_5_goles' => $senora_soltera2[$kp]['logros']['menos_6_5_goles'],
                'logro_over_0_5' => $senora_soltera2[$kp]['logros']['over'],
                'logro_over_3_5' => $senora_soltera2[$kp]['logros']['over_3_5'],
                'logro_1_a_0' => $senora_soltera2[$kp]['logros']['logro1_0'],
                'logro_2_a_0' => $senora_soltera2[$kp]['logros']['logro2_0'],
                'logro_2_a_1' => $senora_soltera2[$kp]['logros']['logro2_1']
            ]);
        }
        return $aray_union;
    }

    

     public static function partidos($fecha_limite)
    {
        $fecha_actual=date('Y-m-d');
        $nombre=array();
        $partidos = DB::table('apocalipsis')->where('estado','=',1)->whereBetween('fecha', [$fecha_actual, $fecha_limite])->get();
        $nombre['PartidosSelects']=$partidos;
        return $nombre;
    }
    public static function partidos_senora($fecha_limite)
    {
        $fecha_actual=date('Y-m-d');
        $nombre=array();
        $partidos = DB::table('senora_soltera')->where('estado','=',1)->whereBetween('fecha', [$fecha_actual, $fecha_limite])->get();
        $nombre['PartidosSenora']=$partidos;
        return $nombre;
    }

    public static function partidos_robin($fecha_limite)
    {
        $fecha_actual=date('Y-m-d');
        $nombre=array();
        $partidos = DB::table('robin_hood')->where('estado','=',1)
        ->whereBetween('fecha', [$fecha_actual, $fecha_limite])
        ->distinct()
        ->get();
/*
        $array_robin=array();$oiu=0;
        foreach($partidos as $element) 
        {
            $array_robin[$oiu]=$element;
            $oiu++;
        }

        
        $arr_doss=array_unique($array_robin, SORT_REGULAR);
        $datosss=array();$uiuy=0;
        foreach($arr_doss as $element) 
        {
            $datosss[$uiuy]=$element;
            $uiuy++;
        }
*/
        $nombre['RobinHood']=$partidos;
        return $nombre;
    }

     public static function apuest($cont)
    {
        $apt=array();
        if($cont==1)
        {
            $apt['apt1']='1X';
            $apt['apt2']='1X';
            return $apt;
        }elseif($cont==2)
        {
            $apt['apt1']='0 a 1';
            $apt['apt2']='0 a 1';
            return $apt;
        }elseif($cont==3)
        {
            $apt['apt1']='0 a 2';
            $apt['apt2']='0 a 2';
            return $apt;
        }elseif($cont==4)
        {
            $apt['apt1']='1 a 2';
            $apt['apt2']='1 a 2';
            return $apt;
        }elseif($cont==5)
        {
            $apt['apt1']='over 3.5';
            $apt['apt2']='over 3.5';
            return $apt;
        }elseif($cont==6)
        {
            $apt['apt1']='1X';
            $apt['apt2']='0 a 1';
            return $apt;
        }elseif($cont==7)
        {
            $apt['apt1']='1X';
            $apt['apt2']='0 a 2';
            return $apt;
        }elseif($cont==8)
        {
            $apt['apt1']='1X';
            $apt['apt2']='1 a 2';
            return $apt;
        }elseif($cont==9)
        {
            $apt['apt1']='1X';
            $apt['apt2']='over 3.5';
            return $apt;
        }elseif($cont==10)
        {
            $apt['apt1']='0 a 1';
            $apt['apt2']='1X';
            return $apt;
        }elseif($cont==11)
        {
            $apt['apt1']='0 a 1';
            $apt['apt2']='1 a 2';
            return $apt;
        }elseif($cont==12)
        {
            $apt['apt1']='0 a 1';
            $apt['apt2']='0 a 2';
            return $apt;
        }elseif($cont==13)
        {
            $apt['apt1']='0 a 1';
            $apt['apt2']='over 3.5';
            return $apt;
        }elseif($cont==14)
        {
            $apt['apt1']='0 a 2';
            $apt['apt2']='1X';
            return $apt;
        }elseif($cont==15)
        {
            $apt['apt1']='0 a 2';
            $apt['apt2']='1 a 2';
            return $apt;
        }elseif($cont==16)
        {
            $apt['apt1']='0 a 2';
            $apt['apt2']='0 a 1';
            return $apt;
        }elseif($cont==17)
        {
            $apt['apt1']='0 a 2';
            $apt['apt2']='over 3.5';
            return $apt;
        }elseif($cont==18)
        {
            $apt['apt1']='over 3.5';
            $apt['apt2']='1X';
            return $apt;
        }elseif($cont==19)
        {
            $apt['apt1']='over 3.5';
            $apt['apt2']='0 a 1';
            return $apt;
        }elseif($cont==20)
        {
            $apt['apt1']='over 3.5';
            $apt['apt2']='0 a 2';
            return $apt;
        }elseif($cont==21)
        {
            $apt['apt1']='over 3.5';
            $apt['apt2']='1 a 2';
            return $apt;
        }elseif($cont==22)
        {
            $apt['apt1']='1 a 2';
            $apt['apt2']='1X';
            return $apt;
        }elseif($cont==23)
        {
            $apt['apt1']='1 a 2';
            $apt['apt2']='0 a 1';
            return $apt;
        }elseif($cont==24)
        {
            $apt['apt1']='1 a 2';
            $apt['apt2']='0 a 2';
            return $apt;
        }elseif($cont==25)
        {
            $apt['apt1']='1 a 2';
            $apt['apt2']='over 3.5';
            return $apt;
        }elseif($cont==26)
        {
            $apt['apt1']='0 a 3';
            $apt['apt2']='------';
            return $apt;
        }elseif($cont==27)
        {
            $apt['apt1']='------';
            $apt['apt2']='0 a 3';
            return $apt;
        }
    }

    public static function name_equipos($id_partido1,$id_partido2,$id_partido3,$id_partido4,$id_partido5)
    {
        $partido=array();
        $partidos_id=array();
        $partidos_id[0]=$id_partido1;
        $partidos_id[1]=$id_partido2;
        $partidos_id[2]=$id_partido3;
        $partidos_id[3]=$id_partido4;
        $partidos_id[4]=$id_partido5;
        for($k=0;$k<count($partidos_id);$k++)
        {
            $data= DB::table('apocalipsis')->where('id','=',$partidos_id[$k])->first();
            $partido[$k]=$data;
        }
        return $partido;
    }

    public static function ubicar_equipo($nombre_equipo,$x_coord)
    {
        $longitud=strlen($nombre_equipo);
        if($longitud==24)
            return $x_coord+0.5+1;
        elseif($longitud==23)
            return $x_coord+1.2+1;
        elseif($longitud==22)
            return $x_coord+2+2.5;
        elseif($longitud==21)
            return $x_coord+2.6+2.5;
        elseif($longitud==20)
            return $x_coord+3.5+2.5;
        elseif($longitud==19)
            return $x_coord+4.4+2.2;
        elseif($longitud==18)
            return $x_coord+5.3+2.1;
        elseif($longitud==17)
            return $x_coord+6.1+2;
        elseif($longitud==16)
            return $x_coord+6.9+2;
        elseif($longitud==15)
            return $x_coord+7.7+1.8;
        elseif($longitud==14)
            return $x_coord+8.5+1.6;
        elseif($longitud==13)
            return $x_coord+9.3+1.6;
        elseif($longitud==12)
            return $x_coord+10.1+1;
        elseif($longitud==11)
            return $x_coord+10.9+1;
        elseif($longitud==10)
            return $x_coord+11.7+1;
        elseif($longitud==9)
            return $x_coord+12.5+1;
        elseif($longitud==8)
            return $x_coord+13.3+0.5;
        elseif($longitud==7)
            return $x_coord+14.1+1;
        elseif($longitud==6)
            return $x_coord+14.9+1;
        elseif($longitud==5)
            return $x_coord+15.7+1;
        elseif($longitud==4)
            return $x_coord+17;
        else
            return $x_coord+17.3+1;
        
    }

    public static function multiplicador_loco($dias,$ip)
    {
        
        $multiplicador=array();
        
        if($dias>0)
        {
            
            $fecha_actual = date('Y-m-d');
            $fecha_sigg=strtotime("+".$dias." day",strtotime($fecha_actual));
            $fecha_final= date('Y-m-d',$fecha_sigg);

            $partidos = DB::table('multiplicador_loco')
            ->orderBy('fecha', 'asc')
            ->whereBetween('fecha', [$fecha_actual, $fecha_final])
            ->distinct()
            ->get();
            //dd($partidos);
        }else
        {
            $dias=7;
            $fecha_actual = date('Y-m-d');
            $fecha_sigg=strtotime("+".$dias." day",strtotime($fecha_actual));
            $fecha_final= date('Y-m-d',$fecha_sigg);
            $data2= DB::table('usuario')->where([
                ['ip','=',$ip],
                ['sesion','=',1]
            ])->get();
            //dd($data2[0]->fecha_registro);
            $partidos = DB::table('multiplicador_loco')
            ->orderBy('fecha', 'asc')
            ->whereBetween('fecha', [$data2[0]->fecha_registro, $fecha_final])
            ->distinct()
            ->get();
        }
        /*$arr_dos=array_unique($arr_todo, SORT_REGULAR);
        $datos=array();$ui=0;
        foreach($arr_dos as $element) 
        {
            $datos[$ui]=$element;
            $ui++;
        }*/
        
        $multiplicador['Multiplicador']=$partidos;
       
        return $multiplicador;
    }

}

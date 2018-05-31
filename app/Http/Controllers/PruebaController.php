<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Prueba;
use PDF;
ini_set('max_execution_time', 10000);
ini_set("user_agent","Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0");


class PruebaController extends Controller
{
    public function get_info($_dias)
    {
        date_default_timezone_set('America/Caracas');
        //  inglaterra,españa,alemania,italia,francia,serieB,Holanda,Portugal,Costa Rica,Escocia,Turquia
        //Colombia, Peru , Chile, Argentina
        $ligas=array();
        
        //$ligas[0]['enlace']='https://www.betfair.com/sport/football?id=117&competitionEventId=259241&action=loadCompetition&modules=multipickavbId@1007&selectedTabType=COMPETITION';
        //$ligas[0]['competencia']='Primera División de España';
        //$ligas[1]['enlace']='https://www.betfair.com/sport/football?id=10932509&competitionEventId=2022802&action=loadCompetition&modules=multipickavbId@1007&selectedTabType=COMPETITION';
        //$ligas[1]['competencia']='English Premier League';
        //$ligas[2]['enlace']='https://www.betfair.com/sport/football?id=59&competitionEventId=605621&action=loadCompetition&modules=multipickavbId@1007&selectedTabType=COMPETITION';
        //$ligas[2]['competencia']='Bundesliga de Alemania';

        //$ligas[0]['enlace']='https://www.betfair.com/sport/football?id=81&competitionEventId=241361&action=loadCompetition&modules=multipickavbId@1007&selectedTabType=COMPETITION';
        //$ligas[0]['competencia']='Serie A de Italia';
        //$ligas[1]['enlace']='https://www.betfair.com/sport/football?id=55&competitionEventId=268416&action=loadCompetition&modules=multipickavbId@1007&selectedTabType=COMPETITION';
        //$ligas[1]['competencia']='Ligue 1 de Francia';
        //$ligas[2]['enlace']='https://www.betfair.com/sport/football?id=83&competitionEventId=241362&action=loadCompetition&modules=multipickavbId@1060&selectedTabType=COMPETITION';
        //$ligas[2]['competencia']='Serie B de Italia';

        //$ligas[0]['enlace']='https://www.betfair.com/sport/football?id=9404054&competitionEventId=3209064&action=loadCompetition&modules=multipickavbId@1059&selectedTabType=COMPETITION';
        //$ligas[0]['competencia']='Eredivisie de Holanda';
        //$ligas[1]['enlace']='https://www.betfair.com/sport/football?id=99&competitionEventId=269462&action=loadCompetition&modules=multipickavbId@1059&selectedTabType=COMPETITION';
        //$ligas[1]['competencia']='bwin Liga de Portugal';
        //$ligas[2]['enlace']='https://www.betfair.com/sport/football?id=2079376&competitionEventId=26870341&action=loadCompetition&modules=multipickavbId@1059&selectedTabType=COMPETITION';
        //$ligas[2]['competencia']='Primera División de Costa Rica';

        //$ligas[0]['enlace']='https://www.betfair.com/sport/football?id=105&otherAction=selectOtherCompetition&competitionEventId=44847&action=loadCompetition&competitionId=105&selectedTabType=COMPETITION';
        //$ligas[0]['competencia']='Premier League de Escocia';
        //$ligas[1]['enlace']='https://www.betfair.com/sport/football?id=194215&competitionEventId=290769&action=loadCompetition&modules=multipickavbId@1059&selectedTabType=COMPETITION';
        //$ligas[1]['competencia']='Super Lig de Turquía';
        //$ligas[2]['enlace']='https://www.betfair.com/sport/football?id=844197&competitionEventId=26670500&action=loadCompetition&modules=multipickavbId@1060&selectedTabType=COMPETITION';
        //$ligas[2]['competencia']='Liga Águila';

        $ligas[0]['enlace']='https://www.betfair.com/sport/football?id=8594603&competitionEventId=27691134&action=loadCompetition&modules=multipickavbId@1060&selectedTabType=COMPETITION';
        $ligas[0]['competencia']='Primera Profesional de Perú';
        $ligas[1]['enlace']='https://www.betfair.com/sport/football?id=744098&competitionEventId=26647705&action=loadCompetition&modules=multipickavbId@1060&selectedTabType=COMPETITION';
        $ligas[1]['competencia']='Primera División de Chile';
        $ligas[2]['enlace']='https://www.betfair.com/sport/football?id=67387&competitionEventId=271711&action=loadCompetition&modules=multipickavbId@1060&selectedTabType=COMPETITION';
        $ligas[2]['competencia']='Superliga Argentina';
            
           // dd($ligas);
        $propia=array();


        for($k=0;$k<count($ligas);$k++)
        {
            
            $html = new \Htmldom($ligas[$k]['enlace']);
            $instancia=$html->find('li[class="section"]');
            $bloques_fecha=count($instancia);   

            //dd($bloques_fecha);
            
            /*$dom = HtmlDomParser::str_get_html( $str );
            or 
            $html = HtmlDomParser::file_get_html($ligas[$k]['enlace']);
            $html = HtmlDomParser::str_get_html($ligas[$k]['enlace']);
            $html = HtmlDomParser::file_get_html($ligas[$k]['enlace']);
            $instancia = $html->find('li[class="section"]');
            $bloques_fecha=count($instancia); */

            /*if($k==1)
                dd($bloques_fecha);*/
            $array_fecha=array();
            $array_numero_juegos=array();
            $partidos_totales=0;
            $array_horas_partidos=array();
            $juegos_por_bloque=array();
            $fecha_actual = date('Y-m-d');
            $cont=0;$cont_enjuego=0;
          
            for($j=0;$j<$_dias;$j++)
            {
                $fecha_formato=Prueba::saber_dia_semana_letra($fecha_actual).', '.Prueba::saber_dia_numero($fecha_actual).' '.Prueba::saber_mes_letra($fecha_actual);
                
                    //dd($fecha_formato);
                if(isset($instancia[$cont]))
                {
                    $fecha_scrap=trim($instancia[$cont]->childNodes(0)->childNodes(0)->plaintext);
                   /*echo ' fecha scraping : '.$fecha_scrap;
                    echo '<br/>';
                    echo ' fecha formato : '.$fecha_formato;
                    echo '<br/>';echo '<br/>';*/
                    if(($fecha_formato == $fecha_scrap)||($fecha_scrap == 'Hoy')||($fecha_scrap == 'Mañana')||($fecha_scrap == 'En Juego'))
                    {
                        
                        if(($fecha_scrap == 'Hoy')&&($cont_enjuego==1))
                        {
                            $fecha_sigg=strtotime("-1 day",strtotime($fecha_actual));
                            $fecha_actual= date('Y-m-d',$fecha_sigg);
                            $fecha_formato=Prueba::saber_dia_semana_letra($fecha_actual).', '.Prueba::saber_dia_numero($fecha_actual).' '.Prueba::saber_mes_letra($fecha_actual);
                        }
                        
                        $array_fecha[$cont]=$fecha_formato;
                        $juegos=$instancia[$cont]->childNodes(1)->childNodes();
                    
                        $partidos_totales+=count($juegos);
                        $array_numero_juegos[$cont]=$partidos_totales;
                        $juegos_por_bloque[$cont]=count($juegos);
                        $cont++;

                        if($fecha_scrap == 'En Juego')
                        {
                            $cont_enjuego=1;
                            //dd($ligas[$k]['competencia']);
                        }
                    }
                
                }
                $fecha_sigg=strtotime("+1 day",strtotime($fecha_actual));
                $fecha_actual= date('Y-m-d',$fecha_sigg);
                
            }
            /*echo 'cont : '.$cont;
            dd($array_fecha);*/
            /*if($k==1)
                dd($array_fecha);*/

            if($cont>0)
            {
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

                

                $dominio='https://www.betfair.com';
                
                $resuesta=array();
                $array_over_cero_punto_cinco=array();
                $array_puntocinco=array();
                $cont_over=0;
               /* $unionn=array();
                if($k==7)
                {
                    $unionn['array_fecha']=$array_fecha;
                    $unionn['array_enlaces']=$array_enlaces;
                    $unionn['juegos_por_bloque']=$juegos_por_bloque;
                    dd($unionn);
                }*/
                
                if(count($array_enlaces)>0)
                {
                    for($i=0,$j=0;$i<count($array_enlaces);$i++)
                    {
                        
                        if($i==($array_numero_juegos[$j]))
                            $j++;

                        $html = new \Htmldom($dominio.$array_enlaces[$i]);
                        $instancia=$html->find('div[class="update-container"]');
                    
                        $hijos=count($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes());
                       
                        $doble_oportunidad=NULL;
                        $mas_menos=NULL;
                        for($r=0;$r<$hijos;$r++)
                        {
                            $dobl_op=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($r)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->plaintext);
                            if(($dobl_op=='Doble oportunidad')||($dobl_op=='Double Chance'))  
                            {
                                $doble_oportunidad=$r;  
                            }
                            if('Más/Menos'==trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($r)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->plaintext))
                            {
                                $mas_menos=$r;
                            }
                            if('Marcador Final'==trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($r)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->plaintext))
                            {
                                $marcador_final=$r; 
                                //dd(count($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes()));                                                                                                                                                                        //aqui itera
                                //$logro0_1=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);
                           
                               // dd($marcador_final);
                            }
                        }

                        
                        if(isset($doble_oportunidad))
                        {
                           
                            // logro 1x
                            if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($doble_oportunidad)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext))
                                $logro=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($doble_oportunidad)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);
                            // logro 1   
                            if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext))                                                                                                                                     //itera        
                                $logro_1=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);
                            // logro X
                            if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(0)->plaintext))
                                $logroX=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(0)->plaintext);
                            // logro 2
                            if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(2)->childNodes(1)->childNodes(0)->plaintext))
                                $logro2=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(2)->childNodes(1)->childNodes(0)->plaintext);
                            
                            if(count($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes())>4)
                            {
                                    //dd($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);
                                // logro Marcador Final 1-0   
                                if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext))                                                                                                                                                                                     //aqui itera
                                    $logro1_0=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);    
                                // logro Marcador Final 2-0      
                                if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(0)->plaintext))                                                                                                                                                                                     //aqui itera
                                    $logro2_0=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(0)->plaintext);    
                                // logro Marcador Final 2-1
                                if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(0)->childNodes(2)->childNodes(1)->childNodes(0)->plaintext))                                                                                                                                                                                     //aqui itera
                                    $logro2_1=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(0)->childNodes(2)->childNodes(1)->childNodes(0)->plaintext);    
                                
                                
                                    // logro Marcador Final 0-1    
                                if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext))                                                                                                                                                                                     //aqui itera
                                    $logro0_1=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext);
                                // logro Marcador Final 0-2                                                                                                                                                                //aqui itera
                                if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(1)->childNodes(1)->childNodes(0)->plaintext))
                                    $logro0_2=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(1)->childNodes(1)->childNodes(0)->plaintext);
                                // logro Marcador Final 1-2                                                                                                                                                                //aqui itera
                                if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(2)->childNodes(1)->childNodes(0)->plaintext))
                                    $logro1_2=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(2)->childNodes(1)->childNodes(0)->plaintext);
                                // logro Marcador Final 0-3                                                                                                                                                                //aqui itera
                                if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(3)->childNodes(1)->childNodes(0)->plaintext))
                                    $logro0_3=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(3)->childNodes(1)->childNodes(0)->plaintext);
                                // logro Marcador Final 1-3                                                                                                                                                                //aqui itera
                                if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(4)->childNodes(1)->childNodes(0)->plaintext))
                                    $logro1_3=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(4)->childNodes(1)->childNodes(0)->plaintext);
                                // logro Marcador Final 2-3                                                                                                                                                                //aqui itera
                                if(isset($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(5)->childNodes(1)->childNodes(0)->plaintext))
                                    $logro2_3=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($marcador_final)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(2)->childNodes(5)->childNodes(1)->childNodes(0)->plaintext);
                            }
                            // logro menos de 6.5 goles en el partido
                            $menos_6_5_goles=0;                                                                                                                                                        //itera         
                            if(count($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($mas_menos)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes())>6)                                                                                                                                     //itera            
                                $menos_6_5_goles=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($mas_menos)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(6)->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->plaintext);
                                            
                           // dd($menos_6_5_goles);

                            $equipo1=$instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($doble_oportunidad)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->plaintext;
                            $equipo2=$instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($doble_oportunidad)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes(1)->childNodes(0)->plaintext;
                    
                        
                            $equipos1 = explode(" y e", $equipo1);
                            $equipos2 = explode(" y e", $equipo2);
                            if(isset($equipos1[1]))
                            {
                                $respuesta[$i]['equipo1']=trim($equipos1[0]);
                            }else{
                                $equipos1 = explode(" And ", $equipo1);
                                $respuesta[$i]['equipo1']=trim($equipos1[0]);
                            }

                            if(isset($equipos2[1]))
                            {
                                $respuesta[$i]['equipo2']=trim($equipos2[0]);
                            }else{
                                $equipos2 = explode(" And ", $equipo2);
                                $respuesta[$i]['equipo2']=trim($equipos2[0]);
                            }
                                
                                $respuesta[$i]['fecha']=Prueba::fecha_bd($array_fecha[$j]);
                                
                                $objeto_local=Prueba::buscar_objeto_resultado($respuesta[$i]['equipo1']);
                                $objeto_visitante=Prueba::buscar_objeto_resultado($respuesta[$i]['equipo2']);
                                
                                if((isset($objeto_local[0]))&&(isset($objeto_visitante[0])))
                                {
                                    $objeto_media_local=array();
                                    $objeto_media_visitante=array();
                                    $respuesta[$i]['enlace_1']=$objeto_local[0]->enlace;
                                    $respuesta[$i]['enlace_2']=$objeto_visitante[0]->enlace;
                                    $respuesta[$i]['local_italiano']=$objeto_local[0]->nombre_italiano;
                                    $respuesta[$i]['visitante_italiano']=$objeto_visitante[0]->nombre_italiano;
                                    //$respuesta[$i]['hora']=trim($array_horas_partidos[$i]);    
                                    $respuesta[$i]['logros']['logro_1X']=trim($logro);
                                    $respuesta[$i]['logros']['logro_1']=trim($logro_1);

                                        $objeto_media_local=Prueba::pp($ligas[$k]['competencia'],$objeto_local[0]->enlace,$objeto_local[0]->nombre_italiano,0);              
                                        $objeto_media_visitante=Prueba::pp($ligas[$k]['competencia'],$objeto_visitante[0]->enlace,$objeto_visitante[0]->nombre_italiano,1);
                                        //dd($objeto_media_visitante);
                                        $ultimos_dos_partidos_empate=false;
                                        $ultimo_partido_cero_cero=false;
                                        //dd(count($objeto_media_local));
                                        if((count($objeto_media_local)==8)&&(count($objeto_media_visitante)==8))
                                        {
                                            $respuesta[$i]['local']=$objeto_media_local;
                                            $respuesta[$i]['visitante']=$objeto_media_visitante;
                                            /*if(($k!=12)&&($k!=13))//la 12 es la liga de peru
                                            {*/
                                               /* $mostrar=array();
                                                $mostrar['local']=$objeto_media_local;
                                                $mostrar['equipo1']=$respuesta[$i]['equipo1'];
                                                $mostrar['enlace_local']=$objeto_local[0]->enlace;
                                                $mostrar['nombre_italiano_local']=$objeto_local[0]->nombre_italiano;

                                                $mostrar['visitante']=$objeto_media_visitante;
                                                $mostrar['equipo2']=$respuesta[$i]['equipo2'];
                                                $mostrar['enlace_visitante']=$objeto_visitante[0]->enlace;
                                                $mostrar['nombre_italiano_visitante']=$objeto_visitante[0]->nombre_italiano;*/
                                                //dd($mostrar);
                                            //}
                                        }else
                                        {
                                            $mostrar=array();
                                            $mostrar['Mensaje']='Este partido presenta problemas';
                                            $mostrar['local']=$respuesta[$i]['equipo1'];
                                            $mostrar['visitante']=$respuesta[$i]['equipo2'];
                                            dd($mostrar);
                                           /* if(isset($objeto_media_local['ultimos_dos_partidos_empate']) && isset($objeto_media_visitante['ultimos_dos_partidos_empate']))
                                            {
                                                if($objeto_media_local['ultimos_dos_partidos_empate']==true || $objeto_media_visitante['ultimos_dos_partidos_empate']==true)
                                                    $ultimos_dos_partidos_empate=true;
                                            }
                                            
                                            if(isset($objeto_media_local['ultimo_partido_cero_cero']) && isset($objeto_media_visitante['ultimo_partido_cero_cero']))
                                            {
                                                if($objeto_media_local['ultimo_partido_cero_cero']==true || $objeto_media_visitante['ultimo_partido_cero_cero']==true)
                                                    $ultimo_partido_cero_cero=true;
                                            }

                                            $respuesta[$i]['media_gol_local']=$objeto_media_local['media'];
                                            $respuesta[$i]['media_gol_visitante']=$objeto_media_visitante['media'];
                                            $respuesta[$i]['ultimos_tres_partidos_empata_o_pierde_local']=$objeto_media_local['ultimos_tres_partidos_empata_o_pierde'];
                                            $respuesta[$i]['ultimas_dos_derrotas_local']=$objeto_media_local['ultimas_dos_derrotas'];
                                            $respuesta[$i]['ultimos_dos_partidos_empate']=$ultimos_dos_partidos_empate;
                                            $respuesta[$i]['ultimo_partido_cero_cero']=$ultimo_partido_cero_cero;*/

                                        }
                                        
                                        if(isset($logro2))
                                            $respuesta[$i]['logros']['logro_2']=$logro2;
                                        if(isset($logroX))    
                                            $respuesta[$i]['logros']['logro_X']=$logroX;
                                        if(isset($logro0_1))
                                            $respuesta[$i]['logros']['logro_0_1']=$logro0_1;
                                        if(isset($logro0_2))
                                            $respuesta[$i]['logros']['logro_0_2']=$logro0_2;
                                        if(isset($logro1_2))
                                            $respuesta[$i]['logros']['logro_1_2']=$logro1_2;
                                        if(isset($logro0_3))
                                            $respuesta[$i]['logros']['logro_0_3']=$logro0_3;
                                        if(isset($logro1_3))
                                            $respuesta[$i]['logros']['logro_1_3']=$logro1_3;
                                        if(isset($logro2_3))
                                            $respuesta[$i]['logros']['logro_2_3']=$logro2_3;
                                        if(isset($menos_6_5_goles))
                                            $respuesta[$i]['logros']['menos_6_5_goles']=$menos_6_5_goles;
                                        if(isset($logro1_0))
                                            $respuesta[$i]['logros']['logro1_0']=$logro1_0;
                                        if(isset($logro2_0))
                                            $respuesta[$i]['logros']['logro2_0']=$logro2_0;
                                        if(isset($logro2_1))
                                            $respuesta[$i]['logros']['logro2_1']=$logro2_1;
                                        //$respuesta[$i]['historial']=$objeto_media_local['historial'];

                                        $numero_bloq=count($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($mas_menos)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes());
                                        $marcado=0;
                                        for($uu=0;$uu<$numero_bloq;$uu++)
                                        {
                                            $texto=$instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($mas_menos)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($uu)->plaintext;
                                            $porciones = explode("</br>", $texto);
                                            if(trim($porciones[0])=='3.5')
                                            {
                                                $marcado_tres_punto_cinco=$uu;
                                            }
                                            if(trim($porciones[0])=='0.5')
                                            {
                                                $marcado_cero_punto_cinco=$uu;
                                            }
                                        }

                                        if(isset($marcado_tres_punto_cinco)){
                                            $over_3_5_goles=trim($instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($mas_menos)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes($marcado_tres_punto_cinco)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->plaintext);
                                            $respuesta[$i]['logros']['over_3_5']=trim($over_3_5_goles);
                                        }
                                        if(isset($marcado_cero_punto_cinco)){
                                            $over=$instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($mas_menos)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes($marcado_cero_punto_cinco)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->plaintext;
                                            $respuesta[$i]['logros']['over']=trim($over);
                                        }
                                            
                                        //dd($respuesta);
                                    
                                }else
                                {
                                    echo 'equipo1 : '.$respuesta[$i]['equipo1'].'<br>';
                                    echo 'equipo2 : '.$respuesta[$i]['equipo2'].'<br>';
                                }
                        }

                        //if(isset($mas_menos))
                        //{
                            //$over=$instancia[0]->childNodes(0)->childNodes(0)->childNodes(1)->childNodes(0)->childNodes($mas_menos)->childNodes(0)->childNodes(1)->childNodes(1)->childNodes(1)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(0)->plaintext;
                            //$array_over_cero_punto_cinco[$cont_over]=trim($over);
                            //$cont_over++;
                          //  echo ' <br>entro Mas/Menos<br> '; 
                        //}
                    }
                   
                    $prop[$k]=$respuesta;
                    //$array_puntocinco[$k]=$array_over_cero_punto_cinco;
                }
            }
            
        }
        //dd($array_puntocinco);
        $l=0;
        if(isset($prop))
        {
            foreach($prop as $element) 
            {
                $propia[$l]=$element;
                $l++;
            }
        }
      // dd($propia);
        if(isset($propia))
        {
            /*for($n=0;$n<count($propia);$n++)
            {
                for($p=0;$p<count($propia[$n]);$p++)
                {
                    if((isset($propia[$n][$p]['enlace_1']))&&(isset($propia[$n][$p]['enlace_2'])))
                    {
                        $objeto_media_local=Prueba::pp($ligas[$k]['competencia'],$propia[$n][$p]['enlace_1'],$propia[$n][$p]['local_italiano'],0);              
                        $objeto_media_visitante=Prueba::pp($ligas[$k]['competencia'],$propia[$n][$p]['enlace_2'],$propia[$n][$p]['visitante_italiano'],1);       
                        
                        $propia[$n][$p]['media_gol_local']=$objeto_media_local['media'];
                        $propia[$n][$p]['media_gol_visitante']=$objeto_media_visitante['media'];          
                    }
                }
            }*/
            //dd($propia);
            //dd($propia);
            return response()->json(Prueba::apocalipsis($propia));
        }else{
            return 'respuesta vacia';
        }
         
    }

    public function get_partidos($dias)
    {
        $fecha_actual=date('Y-m-d');
        $dia="+".$dias." day";
        $fecha_sigg=strtotime($dia,strtotime($fecha_actual));
                $fecha_actual= date('Y-m-d',$fecha_sigg);
        return response()->json(Prueba::partidos($fecha_actual));
    }

    public function get_partidos_senora($dias)
    {
        $fecha_actual=date('Y-m-d');
        $dia="+".$dias." day";
        $fecha_sigg=strtotime($dia,strtotime($fecha_actual));
                $fecha_actual= date('Y-m-d',$fecha_sigg);
        return response()->json(Prueba::partidos_senora($fecha_actual));
    }

    public function get_partidos_robin($dias)
    {
        $fecha_actual=date('Y-m-d');
        $dia="+".$dias." day";
        $fecha_sigg=strtotime($dia,strtotime($fecha_actual));
                $fecha_actual= date('Y-m-d',$fecha_sigg);
        return response()->json(Prueba::partidos_robin($fecha_actual));
    }

    public function reporte($id1,$id2,$id3,$id4,$id5)
    {
        $equipos=array();
        $equipos=Prueba::name_equipos($id1,$id2,$id3,$id4,$id5);
        
        PDF::SetTitle('Combinaciones');//titulo de la pagina del pdf
        
        $cont=0;
        for($h=0;$h<3;$h++)
        {
            PDF::AddPage(); //agregando una nueva pagina en blanco

            $pdf=PDF::Rect (15, 15, 180, 265, '', '', ''); //marco del pdf rectangulo

            $c2=array(0,0,0,30); //color de relleno  definido con 4 valores es interpretado com CMYK para titulo
            $pdf=PDF::Rect(15,15,180,12,'DF','',$c2); //rectangulo que envuelve el titulo del pdf

            $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
            $titulo = '<h1>COMBINACIONES APOCALIPSIS</h1>';//titulo de la planilla en formato pdf
            $pdf=PDF::writeHTMLCell(0, 0, 48, 17, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
    
            $longitud=3;
            $y_header_comb=50;
            $y_circ=45;
            $y_long_ini=49;

            $y_loc=55;$y_vs=58;$y_vis=61;
            for($p=0;$p<3;$p++)
            {
                $x_part=29;$x_ap=59;$x_circ=45;$x_linea_div_ap=59;
                 
                 $x_loc=15;$x_vs=33.5;$x_vis=15;$x_apuesta=61;
                
                if($cont>8){
                       $x_num=$x_circ-3;
                }else{
                        $x_num=$x_circ-2;
                }
                    
                $pdf=PDF::Rect(15,$y_header_comb-1,180,6,'DF','',$c2); //franja de titulo de las combinaciones
               
                for($u=0;$u<$longitud;$u++)
                {

                    $cont++;
                    $pdf=PDF::SetFont('courier', '', 8);//tipo de letra y tamaño
                    $titulo = '<h4>PARTIDOS</h4>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_part, $y_header_comb+0.5, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                    $titulo = '<h4>APUESTAS</h4>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_ap, $y_header_comb+0.5, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                

                    $pdf=PDF::SetFont('helvetica', '', 12);
                    $c_cir=array(100,0,0,0); //color de relleno  definido con 4 valores es interpretado com CMYK 
                    $pdf=PDF::Circle($x_circ, $y_circ, 4, 0, 360, 'DF','',$c_cir);
                    $titulo = '<h4>'.$cont.'</h4>';//texto del circulo
                    $pdf=PDF::writeHTMLCell(0, 0, $x_num, $y_circ-3, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                    

                    /*lineas delgada que separan partidos de apuestas*/
                    $grosor=array('width' => 0,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                    $pdf=PDF::Line($x_linea_div_ap,$y_long_ini,$x_linea_div_ap,$y_long_ini+60,$grosor);//linea vertical delimitador Apuest 
                    $grosor=array('width' => 0.5,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));//estilo para definir grosor de la pagina
                    $pdf=PDF::Line($x_part-14,$y_long_ini+60,$x_part+46,$y_long_ini+60,$grosor);//linea horizontal delimitador Combinacion abajo
                    $pdf=PDF::Line($x_part-14,$y_long_ini-8,$x_part+46,$y_long_ini-8,$grosor);//linea horizontal delimitador Combinacion arriba

                    if($u<($longitud-1))
                    {
                        /*Linea que separa las comninaciones de forma vertical LINEA GRUESA*/
                        $grosor=array('width' => 0.5,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));//estilo para definir grosor de la pagina
                        $pdf=PDF::Line($x_linea_div_ap+16,$y_long_ini-8,$x_linea_div_ap+16,$y_long_ini+60,$grosor);//linea vertical delimitador de combinacion
                        //$pdf=PDF::Line(135,35,135,233,$grosor);//linea vertical delimitador de combinacion
                    }
                    $logro_x=$x_linea_div_ap;
                    $x_linea_div_ap+=60;
                    $x_part+=60;
                    $x_ap+=60;    
                    $x_circ+=60;
                    $x_num+=60;

                    $apt=array();
                    $apt1='';
                    $apt2='';
                    

                    
                    $apt=Prueba::apuest($cont);
                    $apt1=$apt['apt1'];
                    $apt2=$apt['apt2'];
                    $posc_x=$logro_x;
                    for($r=0;$r<5;$r++)
                    {
                        $pdf=PDF::SetFont('helvetica', '', 8.7);//achica la fuente para que entren nombres de equipos largos
                        $posicion_local=Prueba::ubicar_equipo($equipos[$r]['local'],$x_loc);
                        $posicion_visitante=Prueba::ubicar_equipo($equipos[$r]['visitante'],$x_vis);
                        $titulo = '<h4>'.$equipos[$r]['local'].'</h4>';//titulo de la planilla en formato pdf
                        $pdf=PDF::writeHTMLCell(0, 0, $posicion_local, $y_loc, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        $titulo = '<h4>VS</h4>';//titulo de la planilla en formato pdf
                        $pdf=PDF::writeHTMLCell(0, 0, $x_vs, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        $titulo = '<h4>'.$equipos[$r]['visitante'].'</h4>';//titulo de la planilla en formato pdf
                        $pdf=PDF::writeHTMLCell(0, 0, $posicion_visitante, $y_vis, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        
                        if($apt1=='1X')
                            $posc_x_part1=$logro_x+4.8;
                        elseif($apt1=='over 3.5')
                            $posc_x_part1=$logro_x+1;
                        else
                            $posc_x_part1=$logro_x+3.5;
                        
                        if($apt2=='1X')
                            $posc_x_part2=$logro_x+4.8;
                        elseif($apt2=='over 3.5')
                            $posc_x_part2=$logro_x+1;
                        else
                            $posc_x_part2=$logro_x+3.5;
                        

                        if($r==0)
                        {
                            $titulo = '<h4>'.$apt1.'</h4>';//titulo de la planilla en formato pdf
                            $pdf=PDF::writeHTMLCell(0, 0, $posc_x_part1, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        }
                        elseif($r==1)
                        {
                            $titulo = '<h4>'.$apt2.'</h4>';//titulo de la planilla en formato pdf
                            $pdf=PDF::writeHTMLCell(0, 0, $posc_x_part2, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        }elseif(($r==2)||($r==3))
                        {
                            $titulo = '<h4>1</h4>';//titulo de la planilla en formato pdf
                            $pdf=PDF::writeHTMLCell(0, 0, $logro_x+4.8, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        }else
                        {
                            $titulo = '<h4>1X</h4>';//titulo de la planilla en formato pdf
                            $pdf=PDF::writeHTMLCell(0, 0, $logro_x+4.8, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        }

                        $grosor=array('width' => 0,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                        $pdf=PDF::Line(15,$y_vis+4,195,$y_vis+4,$grosor);//linea horizontal delimitador Apuesta
                        $y_loc+=11;
                        $y_vs+=11;
                        $y_vis+=11;
                    }
                     $x_loc+=60;$x_vs+=60;$x_vis+=60;$x_apuesta+=60;
                     if($p==0)
                     {
                         $y_loc=55;$y_vs=58;$y_vis=61;
                     }elseif($p==1)
                     {
                         $y_loc=132;$y_vs=135;$y_vis=138;
                     }else
                     {
                         $y_loc=209;$y_vs=212;$y_vis=215;
                     }
                    
                     
                }

                $y_header_comb+=77;$y_circ+=77;$y_long_ini+=77;
                $y_loc+=77;$y_vs+=77;$y_vis+=77;
            }   
        }
        PDF::Output('Combinaciones_Apocalipsis.pdf','D');
    }

    public function equipos($id1,$id2,$id3,$id4,$id5)
    {
        return response()->json(Prueba::name_equipos($id1,$id2,$id3,$id4,$id5));
    }

     public function get_multiplicador(Request $request)
     {
        $dias=$request->day;
        $ip=$request->ip();
         return response()->json(Prueba::multiplicador_loco($dias,$ip));
     }

     
}

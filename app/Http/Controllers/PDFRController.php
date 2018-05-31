<?php

namespace App\Http\Controllers;
use App\Modelos\Prueba;
use App\Modelos\PDFM;
use Illuminate\Http\Request;
use PDF;

class PDFRController extends Controller
{
    public function reporte_robin($id1,$id2,$id3,$id4,$id5,$monto_apuesta)
    {
        $equipos=array();
        $equipos=PDFM::name_equipos_robin($id1,$id2,$id3,$id4,$id5);
        //dd($equipos[0]);
        PDF::SetTitle('Combinaciones Robin Hood');//titulo de la pagina del pdf
        
        $cont=0;
        for($h=0;$h<2;$h++)
        {
            PDF::AddPage(); //agregando una nueva pagina en blanco

            //$pdf=PDF::Rect (15, 15, 180, 270, '', '', ''); //marco del pdf rectangulo

            $c2=array(0,0,0,40); //color de relleno  definido con 4 valores es interpretado com CMYK para titulo
            $pdf=PDF::Rect(15,15,180,12,'DF','',$c2); //rectangulo que envuelve el titulo del pdf
            $pdf=PDF::Rect(15,15,180,12,'DF','',$c2); //rectangulo que envuelve el titulo del pdf

            $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
            $titulo = '<h1>COMBINACIONES ROBIN HOOD (Apuesta:'.$monto_apuesta.'$)</h1>';//titulo de la planilla en formato pdf
            $pdf=PDF::writeHTMLCell(0, 0, 24, 17, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
    
            $longitud=3;
            $y_header_comb=36;//antes 50
            $y_circ=31;//antes 45 (se le resta 14)
            $y_long_ini=35; //antes 49

            $y_loc=41;$y_vs=44;$y_vis=46;//$y_loc=55;$y_vs=58;$y_vis=61;
            for($p=0;$p<3;$p++)
            {
                $x_part=29;$x_ap=59;$x_circ=45;$x_linea_div_ap=59;
                 
                 $x_loc=15;$x_vs=33.5;$x_vis=15;$x_apuesta=61;
                
                if($cont>8){
                       $x_num=$x_circ-3;
                }else{
                        $x_num=$x_circ-2;
                }
                    
                $pdf=PDF::Rect(15,$y_header_comb-1,180,6,'DF','',$c2); //rectangulo gris Partidos | Apuestas
                $est=array(0,0,0,14); //color de relleno  definido con 4 valores es interpretado com CMYK para titulo
                $pdf=PDF::Rect(15,$y_long_ini+54,180,16,'DF','',$est); //rectangulo gris para premios y %
                
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
                    $pdf=PDF::Line($x_linea_div_ap,$y_long_ini,$x_linea_div_ap,$y_long_ini+70,$grosor);//linea vertical delimitador Apuest 
                    $grosor=array('width' => 0.5,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));//estilo para definir grosor de la pagina
                    //$pdf=PDF::Line($x_part-14,$y_long_ini+60,$x_part+46,$y_long_ini+60,$grosor);//linea horizontal delimitador Combinacion abajo
                    if($p>0)
                        $pdf=PDF::Line($x_part-14,$y_long_ini-8,$x_part+46,$y_long_ini-8,$grosor);//linea horizontal delimitador Combinacion arriba
                    
                    if($u<($longitud-1))
                    {
                        
                            $y_pr=$y_long_ini-8;
                        /*Linea que separa las comninaciones de forma vertical LINEA GRUESA*/
                        $grosor=array('width' => 0.5,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));//estilo para definir grosor de la pagina
                        $pdf=PDF::Line($x_linea_div_ap+16,$y_pr,$x_linea_div_ap+16,$y_long_ini+70,$grosor);//linea vertical delimitador de combinacion
                        
                        $pdf=PDF::Line(15,$y_pr,15,$y_long_ini+70,$grosor);//linea divisora mas izquiera
                        $pdf=PDF::Line(195,$y_pr,195,$y_long_ini+70,$grosor);//linea divisora mas derecha
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
                    $apt3='';
                    

                    $apt=PDFM::apuest($cont);
                    $apt1=$apt['apt1'];
                    $apt4='1X';
                    $apt5=$apt['apt5'];
                    $posc_x=$logro_x;

                    for($r=0;$r<5;$r++)
                    {
                        $pdf=PDF::SetFont('helvetica', '', 8);//achica la fuente para que entren nombres de equipos largos
                        $posicion_local=Prueba::ubicar_equipo($equipos[$r]->equipo1,$x_loc);
                        $posicion_visitante=Prueba::ubicar_equipo($equipos[$r]->equipo2,$x_vis);
                        $titulo = '<h4>'.$equipos[$r]->equipo1.'</h4>';//titulo de la planilla en formato pdf
                        $pdf=PDF::writeHTMLCell(0, 0, $posicion_local, $y_loc, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        $titulo = '<h5>VS</h5>';//titulo de la planilla en formato pdf
                        $pdf=PDF::writeHTMLCell(0, 0, $x_vs, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        $titulo = '<h4>'.$equipos[$r]->equipo2.'</h4>';//titulo de la planilla en formato pdf
                        $pdf=PDF::writeHTMLCell(0, 0, $posicion_visitante, $y_vis, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        
                        if($apt1=='1X')
                            $posc_x_part1=$logro_x+4.8;
                        elseif($apt1=='over 3.5')
                            $posc_x_part1=$logro_x+1;
                        else
                            $posc_x_part1=$logro_x+3.5;
                        
                        if($apt4=='1X')
                            $posc_x_part2=$logro_x+4.8;
                        
                        if($apt5=='1X')
                            $posc_x_part2=$logro_x+4.8;
                        elseif($apt5=='over 3.5')
                            $posc_x_part2=$logro_x+1;
                        else
                            $posc_x_part2=$logro_x+3.5;
                        

                        if($r==0)
                        {
                            $titulo = '<h4>'.$apt1.'</h4>';//titulo de la planilla en formato pdf
                            $pdf=PDF::writeHTMLCell(0, 0, $posc_x_part1, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        }
                        elseif(($r==1)||($r==2))
                        {
                            $titulo = '<h4>1</h4>';//titulo de la planilla en formato pdf
                            $pdf=PDF::writeHTMLCell(0, 0, $posc_x_part2, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        }elseif($r==3)
                        {
                            $titulo = '<h4>'.$apt4.'</h4>';//titulo de la planilla en formato pdf
                            $pdf=PDF::writeHTMLCell(0, 0, $logro_x+4.8, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        }else
                        {
                            $titulo = '<h4>'.$apt5.'</h4>';//titulo de la planilla en formato pdf
                            $pdf=PDF::writeHTMLCell(0, 0, $logro_x+4.8, $y_vs, $titulo, 0, 1, 0, true, '', true);//escribe el texto en la hoja
                        }

                        if($r<4 && $u==0)
                        {
                            //-------------------delimitador de partidos horizontal para cada ticket
                            $grosor=array('width' => 0,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                            $pdf=PDF::Line(15,$y_vis+4,195,$y_vis+4,$grosor);//linea horizontal delimitador Apuesta
                        }
                        $y_loc+=10;
                        $y_vs+=10;
                        $y_vis+=10;
                    }
                    $y_exc=$y_vis;
                    $pdf=PDF::SetFont('helvetica', '', 12);//tipo de letra y tamaño
                    $titulo = '<h6>Apuesta Ticket</h6>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_part-64, $y_exc-7, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
                    
                    $pdf=PDF::SetFont('helvetica', '', 12);//tipo de letra y tamaño
                    $titulo = '<h6>Cuota Ticket</h6>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_part-64, $y_exc-3, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
                    
                    $pdf=PDF::SetFont('helvetica', '', 12);//tipo de letra y tamaño
                    $titulo = '<h6>Ganancia Ticket (%)</h6>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_part-64, $y_exc+1, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
                    
                    $pdf=PDF::SetFont('helvetica', '', 12);//tipo de letra y tamaño
                    $titulo = '<h6>Ganancia Ticket ($)</h6>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_part-64, $y_exc+5, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
                    

                    $ap_ticket=PDFM::apuesta_ticket_robin($cont,$monto_apuesta);
                    

                    $cuota_ticket=round(PDFM::logro_combinado($apt1,$apt5,$equipos),2);
                    $ganancia_neta=round(($ap_ticket*$cuota_ticket)-$monto_apuesta,2);
                    
                    /*if($ganancia_neta<0)
                    {
                        $porcentaje_ganancia_neta=round((($ganancia_neta*(-1))*100)/$monto_apuesta,2);
                    }else{
                        $porcentaje_ganancia_neta=round(($ganancia_neta*100)/$monto_apuesta,2);
                    }*/
                    $porcentaje_ganancia_neta=round(($ganancia_neta*100)/$monto_apuesta,2);
                    
                    $pdf=PDF::SetFont('helvetica', '', 12);//tipo de letra y tamaño
                    $titulo = '<h6>'.round($ap_ticket, 2).' $</h6>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_part-28, $y_exc-7, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
                    
                    $pdf=PDF::SetFont('helvetica', '', 12);//tipo de letra y tamaño
                    $titulo = '<h6>'.$cuota_ticket.'</h6>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_part-28, $y_exc-3, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
                    
                    $pdf=PDF::SetFont('helvetica', '', 12);//tipo de letra y tamaño
                    $titulo = '<h6>'.$porcentaje_ganancia_neta.' %</h6>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_part-28, $y_exc+1, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
                    
                    $pdf=PDF::SetFont('helvetica', '', 12);//tipo de letra y tamaño
                    $titulo = '<h6>'.$ganancia_neta.' $</h6>';//titulo de la planilla en formato pdf
                    $pdf=PDF::writeHTMLCell(0, 0, $x_part-28, $y_exc+5, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
                    



                     $x_loc+=60;$x_vs+=60;$x_vis+=60;$x_apuesta+=60;
                     if($p==0)
                     {
                        $y_loc=41;$y_vs=44;$y_vis=46;//$y_loc=55;$y_vs=58;$y_vis=61;
                     }elseif($p==1)
                     {
                         $y_loc=122;$y_vs=125;$y_vis=127;//$y_loc=132;$y_vs=135;$y_vis=138;
                     }else
                     {
                         $y_loc=203;$y_vs=206;$y_vis=208;//$y_loc=209;$y_vs=212;$y_vis=215;
                     }

                        if($cont==17)
                        {
                            break;
                        }
                    
                }
           
                $grosor=array('width' => 0,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                $pdf=PDF::Line(15,$y_long_ini+58,195,$y_long_ini+58,$grosor);//linea vertical delimitador de combinacion
                $pdf=PDF::Line(15,$y_long_ini+62,195,$y_long_ini+62,$grosor);//linea vertical delimitador de combinacion
                $pdf=PDF::Line(15,$y_long_ini+66,195,$y_long_ini+66,$grosor);//linea vertical delimitador de combinacion
                //$pdf=PDF::Line(15,$y_long_ini+70,195,$y_long_ini+70,$grosor);//linea vertical delimitador de combinacion
                if($cont==17)
                {
                    /*sE SIBUJA RECTANGULO BLANCO SIN BORDE PARA TAPAR*/
                    $est0=array('width' => 0,'join' => 'round', 'dash' => 0, 'color' => array(255, 255, 255)); 
                    $ct=array(0,0,0,0); //color de relleno  definido con 4 valores es interpretado com CMYK 
                    $pdf=PDF::SetLineStyle($est0); 
                    $pdf=PDF::Rect(75.3,188,121,80,'DF','',$ct);
                    break;
                }
                
                /*$y_header_comb+=77;$y_circ+=77;$y_long_ini+=77;
                $y_loc+=77;$y_vs+=77;$y_vis+=77;*/
                $y_header_comb+=81;$y_circ+=81;$y_long_ini+=81;
                $y_loc+=81;$y_vs+=81;$y_vis+=81;
            }   
        }
        PDF::Output('Combinaciones_Robin_hood.pdf','I');
    }
}

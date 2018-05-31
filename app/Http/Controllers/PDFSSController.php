<?php
namespace App\Http\Controllers;
use App\Modelos\Prueba;
use App\Modelos\PDFM;
use Illuminate\Http\Request;
use PDF;


class PDFSSController extends Controller
{
    public function reporte_senora($local,$visitante,$monto,$pronostico1,$pronostico2,$pronostico3,$pronostico4,$pronostico5,$pronostico6,
                                         $cuota1,$cuota2,$cuota3,$cuota4,$cuota5,$cuota6,
                                         $porcentaje1,$porcentaje2,$porcentaje3,$porcentaje4,$porcentaje5,$porcentaje6,
                                         $apuesta1,$apuesta2,$apuesta3,$apuesta4,$apuesta5,$apuesta6,
                                         $ganancia1,$ganancia2,$ganancia3,$ganancia4,$ganancia5,$ganancia6,
                                         $ganancia_neta1,$ganancia_neta2,$ganancia_neta3,$ganancia_neta4,$ganancia_neta5,$ganancia_neta6,
                                         $porcentaje_ganancia1,$porcentaje_ganancia2,$porcentaje_ganancia3,$porcentaje_ganancia4,$porcentaje_ganancia5,$porcentaje_ganancia6,
                                         $no1,$no2,$no3,$no4,$no5,$no6)
    {
            $objeto['local']=$local;$objeto['visitante']=$visitante;$objeto['monto']=$monto;
            $objeto['pronostico'][0]=$pronostico1;   $objeto['pronostico'][1]=$pronostico2;
            $objeto['pronostico'][2]=$pronostico3;   $objeto['pronostico'][3]=$pronostico4;
            $objeto['pronostico'][4]=$pronostico5;   $objeto['pronostico'][5]=$pronostico6;

            $objeto['cuota'][0]=$cuota1;   $objeto['cuota'][1]=$cuota2;
            $objeto['cuota'][2]=$cuota3;   $objeto['cuota'][3]=$cuota4;
            $objeto['cuota'][4]=$cuota5;   $objeto['cuota'][5]=$cuota6;

            $objeto['porcentaje'][0]=$porcentaje1;   $objeto['porcentaje'][1]=$porcentaje2;
            $objeto['porcentaje'][2]=$porcentaje3;   $objeto['porcentaje'][3]=$porcentaje4;
            $objeto['porcentaje'][4]=$porcentaje5;   $objeto['porcentaje'][5]=$porcentaje6;

            $objeto['apuesta'][0]=$apuesta1;   $objeto['apuesta'][1]=$apuesta2;
            $objeto['apuesta'][2]=$apuesta3;   $objeto['apuesta'][3]=$apuesta4;
            $objeto['apuesta'][4]=$apuesta5;   $objeto['apuesta'][5]=$apuesta6;

            $objeto['ganancia'][0]=$ganancia1;   $objeto['ganancia'][1]=$ganancia2;
            $objeto['ganancia'][2]=$ganancia3;   $objeto['ganancia'][3]=$ganancia4;
            $objeto['ganancia'][4]=$ganancia5;   $objeto['ganancia'][5]=$ganancia6;

            $objeto['ganancia_neta'][0]=$ganancia_neta1;   $objeto['ganancia_neta'][1]=$ganancia_neta2;
            $objeto['ganancia_neta'][2]=$ganancia_neta3;   $objeto['ganancia_neta'][3]=$ganancia_neta4;
            $objeto['ganancia_neta'][4]=$ganancia_neta5;   $objeto['ganancia_neta'][5]=$ganancia_neta6;

            $objeto['porcentaje_ganancia'][0]=$porcentaje_ganancia1;   $objeto['porcentaje_ganancia'][1]=$porcentaje_ganancia2;
            $objeto['porcentaje_ganancia'][2]=$porcentaje_ganancia3;   $objeto['porcentaje_ganancia'][3]=$porcentaje_ganancia4;
            $objeto['porcentaje_ganancia'][4]=$porcentaje_ganancia5;   $objeto['porcentaje_ganancia'][5]=$porcentaje_ganancia6;

            $objeto['no'][0]=$no1;   $objeto['no'][1]=$no2;
            $objeto['no'][2]=$no3;   $objeto['no'][3]=$no4;
            $objeto['no'][4]=$no5;   $objeto['no'][5]=$no6;
        
        
        //return response()->json($objeto);

        PDF::SetTitle('Reprte Senora Soltera');//titulo de la pagina del pdf

        PDF::AddPage(); //agregando una nueva pagina en blanco

        //$pdf=PDF::Rect (15, 15, 180, 270, '', '', ''); //marco del pdf rectangulo

       
        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h1>SEÑORA SOLTERA Partido A</h1>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 52, 17, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
        
        //linea de subrayado
        $y_line=25;
        $grosor=array('width' => 0,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
        $pdf=PDF::Line(121,$y_line,152,$y_line,$grosor);//linea vertical delimitador Apuest 
        
        //seccion de partido
        $c2=array(0,0,0,30); //color de relleno  definido con 4 valores es interpretado com CMYK para titulo
        $pdf=PDF::Rect(25,31,120,7,'DF','',$c2); //rectangulo que envuelve el titulo del pdf
        $c3=array(0,0,100,0);
        $pdf=PDF::Rect(25,38,120,7,'DF','',$c3); //rectangulo que envuelve el titulo del pdf

        //seccion de monto
        $c2=array(0,0,0,30); //color de relleno  definido con 4 valores es interpretado com CMYK para titulo
        $pdf=PDF::Rect(150,31,30,7,'DF','',$c2); //rectangulo que envuelve el titulo del pdf
        $c3=array(0,0,100,0);
        $pdf=PDF::Rect(150,38,30,7,'DF','',$c3); //rectangulo que envuelve el titulo del pdf

        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h4>Partido</h4>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 77, 31, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
        
        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h5>'.$objeto['local']=$local.' vs '.$objeto['visitante']=$visitante.'</h5>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 62, 38, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
        
        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h4>Monto</h4>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 157, 31, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
        
        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h5>'.$objeto['monto']=$monto.'$</h5>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 160, 38, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
            /*Tabla de contenido*/



        PDF::Output('Reporte_Senora_Soltera.pdf','I');
    }

    public function reporte_senora_balanceado($local,$visitante,$monto,$pronostico1,$pronostico2,$pronostico3,$pronostico4,$pronostico5,$pronostico6,$pronostico7,
                                         $cuota1,$cuota2,$cuota3,$cuota4,$cuota5,$cuota6,$cuota7,
                                         $porcentaje1,$porcentaje2,$porcentaje3,$porcentaje4,$porcentaje5,$porcentaje6,$porcentaje7,
                                         $apuesta1,$apuesta2,$apuesta3,$apuesta4,$apuesta5,$apuesta6,$apuesta7,
                                         $ganancia1,$ganancia2,$ganancia3,$ganancia4,$ganancia5,$ganancia6,$ganancia7,
                                         $ganancia_neta1,$ganancia_neta2,$ganancia_neta3,$ganancia_neta4,$ganancia_neta5,$ganancia_neta6,$ganancia_neta7,
                                         $porcentaje_ganancia1,$porcentaje_ganancia2,$porcentaje_ganancia3,$porcentaje_ganancia4,$porcentaje_ganancia5,$porcentaje_ganancia6,$porcentaje_ganancia7,
                                         $no1,$no2,$no3,$no4,$no5,$no6,$no7)
    {
            $objeto['local']=$local;$objeto['visitante']=$visitante;$objeto['monto']=$monto;
            $objeto[0]['pronostico']=$pronostico1;   $objeto[1]['pronostico']=$pronostico2;
            $objeto[2]['pronostico']=$pronostico3;   $objeto[3]['pronostico']=$pronostico4;
            $objeto[4]['pronostico']=$pronostico5;   $objeto[5]['pronostico']=$pronostico6;
            $objeto[6]['pronostico']=$pronostico7;

            $objeto[0]['cuota']=$cuota1;   $objeto[1]['cuota']=$cuota2;
            $objeto[2]['cuota']=$cuota3;   $objeto[3]['cuota']=$cuota4;
            $objeto[4]['cuota']=$cuota5;   $objeto[5]['cuota']=$cuota6;
            $objeto[6]['cuota']=$cuota7;

            $objeto[0]['porcentaje']=$porcentaje1;   $objeto[1]['porcentaje']=$porcentaje2;
            $objeto[2]['porcentaje']=$porcentaje3;   $objeto[3]['porcentaje']=$porcentaje4;
            $objeto[4]['porcentaje']=$porcentaje5;   $objeto[5]['porcentaje']=$porcentaje6;
            $objeto[6]['porcentaje']=$porcentaje7;

            $objeto[0]['apuesta']=$apuesta1;   $objeto[1]['apuesta']=$apuesta2;
            $objeto[2]['apuesta']=$apuesta3;   $objeto[3]['apuesta']=$apuesta4;
            $objeto[4]['apuesta']=$apuesta5;   $objeto[5]['apuesta']=$apuesta6;
            $objeto[6]['apuesta']=$apuesta7;

            $objeto[0]['ganancia']=$ganancia1;   $objeto[1]['ganancia']=$ganancia2;
            $objeto[2]['ganancia']=$ganancia3;   $objeto[3]['ganancia']=$ganancia4;
            $objeto[4]['ganancia']=$ganancia5;   $objeto[5]['ganancia']=$ganancia6;
            $objeto[6]['ganancia']=$ganancia7;

            $objeto[0]['ganancia_neta']=$ganancia_neta1;   $objeto[1]['ganancia_neta']=$ganancia_neta2;
            $objeto[2]['ganancia_neta']=$ganancia_neta3;   $objeto[3]['ganancia_neta']=$ganancia_neta4;
            $objeto[4]['ganancia_neta']=$ganancia_neta5;   $objeto[5]['ganancia_neta']=$ganancia_neta6;
            $objeto[6]['ganancia_neta']=$ganancia_neta7;

            $objeto[0]['porcentaje_ganancia']=$porcentaje_ganancia1;   $objeto[1]['porcentaje_ganancia']=$porcentaje_ganancia2;
            $objeto[2]['porcentaje_ganancia']=$porcentaje_ganancia3;   $objeto[3]['porcentaje_ganancia']=$porcentaje_ganancia4;
            $objeto[4]['porcentaje_ganancia']=$porcentaje_ganancia5;   $objeto[5]['porcentaje_ganancia']=$porcentaje_ganancia6;
            $objeto[6]['porcentaje_ganancia']=$porcentaje_ganancia7;

            $objeto[0]['no']=$no1;   $objeto[1]['no']=$no2;
            $objeto[2]['no']=$no3;   $objeto[3]['no']=$no4;
            $objeto[4]['no']=$no5;   $objeto[5]['no']=$no6;
            $objeto[6]['no']=$no7;
        
       

        PDF::SetTitle('Reprte Senora Soltera');//titulo de la pagina del pdf

        PDF::AddPage(); //agregando una nueva pagina en blanco

        //$pdf=PDF::Rect (15, 15, 180, 270, '', '', ''); //marco del pdf rectangulo

        
        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h1>SEÑORA SOLTERA Partido B</h1>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 52, 17, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
        
        //linea de subrayado
        $y_line=25;
        $grosor=array('width' => 0,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
        $pdf=PDF::Line(121,$y_line,152,$y_line,$grosor);//linea vertical delimitador Apuest 
        
        //seccion de partido
        $c2=array(0,0,0,30); //color de relleno  definido con 4 valores es interpretado com CMYK para titulo
        $pdf=PDF::Rect(25,31,120,7,'DF','',$c2); //rectangulo que envuelve el titulo del pdf
        $c3=array(0,0,100,0);
        $pdf=PDF::Rect(25,38,120,7,'DF','',$c3); //rectangulo que envuelve el titulo del pdf

        //seccion de monto
        $c2=array(0,0,0,30); //color de relleno  definido con 4 valores es interpretado com CMYK para titulo
        $pdf=PDF::Rect(150,31,30,7,'DF','',$c2); //rectangulo que envuelve el titulo del pdf
        $c3=array(0,0,100,0);
        $pdf=PDF::Rect(150,38,30,7,'DF','',$c3); //rectangulo que envuelve el titulo del pdf

        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h4>Partido</h4>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 77, 31, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
        
        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h5>'.$objeto['local']=$local.' vs '.$objeto['visitante']=$visitante.'</h5>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 62, 38, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
        
        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h4>Monto</h4>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 157, 31, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
        
        $pdf=PDF::SetFont('helvetica', '', 14);//tipo de letra y tamaño
        $titulo = '<h5>'.$objeto['monto']=$monto.'$</h5>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, 160, 38, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
            /*Tabla de contenido*/

        
        $c4=array(0,0,0,0); //color de relleno  definido con 4 valores es interpretado com CMYK para titulo
        $pdf=PDF::Rect(20,50,167,56,'DF','',$c4); //cabecera de la tabla
        
        $c2=array(0,0,0,30); //color de relleno  definido con 4 valores es interpretado com CMYK para titulo
        $pdf=PDF::Rect(20,50,167,7,'DF','',$c2); //cabecera de la tabla

        

        $pdf=PDF::SetFont('helvetica', '', 8);//tipo de letra y tamaño
        $y1=50;$y2=106;
        $x1=40;$x_texto=20;$y_texto=51;
        $y_linea_h=64;
        $titulo = '<h3>Pronostico</h3>';//titulo de la planilla en formato pdf
        $pdf=PDF::writeHTMLCell(0, 0, $x_texto, $y_texto, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
           
        for($i=0;$i<7;$i++)
        {
            if($i<6){
                $grosor=array('width' => 0,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                $pdf=PDF::Line($x1,$y1,$x1,$y2,$grosor);//linea vertical delimitador Apuest 
            }else{
                $grosor=array('width' => 0,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
                $pdf=PDF::Line($x1+2,$y1,$x1+2,$y2,$grosor);//linea vertical delimitador Apuest 
            }
            
            $grosor=array('width' => 0,'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
            $pdf=PDF::Line(20,$y_linea_h,187,$y_linea_h,$grosor);//linea vertical delimitador Apuest 
           
            if($i==0){
                $x_texto+=3;
                $titulo = '<h3>Cuota</h3>';
            }elseif($i==1){
                $x_texto-=3;
                $titulo = '<h3>Porcentaje</h3>';
            }elseif($i==2){
                $titulo = '<h3>Apostado</h3>';
            }elseif($i==3){
                $titulo = '<h3>Ganancia</h3>';
            }elseif($i==4){
                $x_texto++;
                $titulo = '<h3>G. Neta</h3>';
            }elseif($i==5){
                $x_texto-=1;
                $titulo = '<h3>% Ganancia</h3>';
            }elseif($i==6){
                $x_texto+=6;
                $titulo = '<h3>NO</h3>';
            }

            $pdf=PDF::writeHTMLCell(0, 0, $x_texto+21, $y_texto, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
           
            $x1+=21;$x_texto+=21;
            $y_linea_h+=7;
        }
        $pdf=PDF::SetFont('helvetica', '', 7);//tipo de letra y tamaño
        for($i=0;$i<7;$i++)
        {
            $x_texto_result=24;
            $y_texto+=7;
            for($j=0;$j<8;$j++)
            {
                
                if($j==0){
                    $titulo = '<h3>'.$objeto[$i]['pronostico'].'</h3>';
                }elseif($j==1){
                    $titulo = '<h3>'.$objeto[$i]['cuota'].'</h3>';
                }elseif($j==2){
                    $titulo = '<h3>'.$objeto[$i]['porcentaje'].' %</h3>';
                }elseif($j==3){
                    $titulo = '<h3>'.$objeto[$i]['apuesta'].'</h3>';
                }elseif($j==4){
                    $titulo = '<h3>'.$objeto[$i]['ganancia'].'</h3>';
                }elseif($j==5){
                    $titulo = '<h3>'.$objeto[$i]['ganancia_neta'].'</h3>';
                }elseif($j==6){
                    $titulo = '<h3>'.$objeto[$i]['porcentaje_ganancia'].'</h3>';
                }else{
                    $x_texto_result+=4;
                    if($objeto[$i]['no']=='true')
                        $titulo = '<h3>X</h3>';
                    else
                        $titulo = '<h3>&#10004;</h3>';
                }
                
                $pdf=PDF::writeHTMLCell(0, 0, $x_texto_result, $y_texto, $titulo, 0, 1, 0, true, '', true);//escribe u ubica el texto en la hoja
                $x_texto_result+=21;
            }
        }
        
        PDF::Output('Reporte_Senora_Soltera.pdf','I');
    }
}

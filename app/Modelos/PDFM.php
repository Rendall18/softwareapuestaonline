<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
class PDFM extends Model
{
    public static function logro_combinado($logro1,$logro2,$objeto_partido)
    {
        /*$obje['logro1']=$logro1;
        $obje['logro5']=$logro2;*/
        $obje['objeto']=$objeto_partido;
        //dd($obje);
        //$logro3='1';$logro4='1';$logro5='1X';
        $cant1=0;$cant5=0;
        $cant2=$objeto_partido[1]->logro_1;
        $cant3=$objeto_partido[2]->logro_1;
        $cant4=$objeto_partido[3]->logro_1x;
        
        if($logro1=='1X') 
            $cant1=$objeto_partido[0]->logro_1x;
        elseif($logro1=='2')
             $cant1=$objeto_partido[0]->logro_2;
        else
            $cant1=1;
        
        if($logro2=='1') 
            $cant5=$objeto_partido[4]->logro_1;
        elseif($logro2=='X')
             $cant5=$objeto_partido[4]->logro_x;
        elseif($logro2=='0 a 1')
             $cant5=$objeto_partido[4]->logro_0_a_1;
        elseif($logro2=='1 a 2')
             $cant5=$objeto_partido[4]->logro_1_a_2;
        elseif($logro2=='0 a 2') 
            $cant5=$objeto_partido[4]->logro_0_a_2;
        elseif($logro2=='0 a 3')
             $cant5=$objeto_partido[4]->logro_0_a_3;
        elseif($logro2=='1 a 3')
             $cant5=$objeto_partido[4]->logro_1_a_3;
        elseif($logro2=='2 a 3')
             $cant5=$objeto_partido[4]->logro_2_a_3;
        else
            $cant5=1;

            $obj['logro1']=$cant1;
            $obj['logro2']=$cant2;
            $obj['logro3']=$cant3;
            $obj['logro4']=$cant4;
            $obj['logro5']=$cant5;
           // dd($obj);
        return ($cant1*$cant2*$cant3*$cant4*$cant5);
        
    }

    public static function logro_combinado_apocalipsis($logro1,$logro2,$objeto_partido)
    {
        /*$obje['logro1']=$logro1;
        $obje['logro5']=$logro2;*/
        $obje['objeto']=$objeto_partido;
        //dd($obje);
        //$logro3='1';$logro4='1';$logro5='1X';
        $cant1=0;$cant2=0;
        $cant3=$objeto_partido[2]->logro_1;
        $cant4=$objeto_partido[3]->logro_1;
        $cant5=$objeto_partido[4]->logro_1x;
        
        if($logro1=='1X') 
            $cant1=$objeto_partido[0]->logro_1x;
        elseif($logro1=='0 a 1')
             $cant1=$objeto_partido[0]->logro_0_a_1;
        elseif($logro1=='0 a 2') 
             $cant1=$objeto_partido[0]->logro_0_a_2;
        elseif($logro1=='1 a 2')
             $cant1=$objeto_partido[0]->logro_1_a_2;
        elseif($logro1=='over 3.5')
             $cant1=$objeto_partido[0]->logro_over_3_5;
        elseif($logro1=='0 a 3')
             $cant1=$objeto_partido[0]->logro_0_a_3;
        else
            $cant1=1;
        
        if($logro2=='1X') 
            $cant2=$objeto_partido[1]->logro_1x;
        elseif($logro2=='0 a 1')
             $cant2=$objeto_partido[1]->logro_0_a_1;
        elseif($logro2=='0 a 2') 
             $cant2=$objeto_partido[1]->logro_0_a_2;
        elseif($logro2=='1 a 2')
             $cant2=$objeto_partido[1]->logro_1_a_2;
        elseif($logro2=='over 3.5')
             $cant2=$objeto_partido[1]->logro_over_3_5;
        elseif($logro2=='0 a 3')
             $cant2=$objeto_partido[1]->logro_0_a_3;
        else
            $cant2=1;

            $obj['logro1']=$cant1;
            $obj['logro2']=$cant2;
            $obj['logro3']=$cant3;
            $obj['logro4']=$cant4;
            $obj['logro5']=$cant5;
           // dd($obj);
        return ($cant1*$cant2*$cant3*$cant4*$cant5);
        
    }

    public static function apuesta_ticket_apocalipsis($cont,$monto_apuesta)
    {
        if($cont==1) $ap_ticket=$monto_apuesta*0.05;
        if($cont==2) $ap_ticket=$monto_apuesta*0.01667;
        if($cont==3) $ap_ticket=$monto_apuesta*0.01667;
        if($cont==4) $ap_ticket=$monto_apuesta*0.01667;
        if($cont==5) $ap_ticket=$monto_apuesta*0.066;
        if($cont==6) $ap_ticket=$monto_apuesta*0.0333;
        if($cont==7) $ap_ticket=$monto_apuesta*0.0333;
        if($cont==8) $ap_ticket=$monto_apuesta*0.0333;
        if($cont==9) $ap_ticket=$monto_apuesta*0.066;
        if($cont==10) $ap_ticket=$monto_apuesta*0.0333;
        if($cont==11) $ap_ticket=$monto_apuesta*0.01667;
        if($cont==12) $ap_ticket=$monto_apuesta*0.01667;
        if($cont==13) $ap_ticket=$monto_apuesta*0.066;
        if($cont==14) $ap_ticket=$monto_apuesta*0.0333;
        if($cont==15) $ap_ticket=$monto_apuesta*0.01667;
        if($cont==16) $ap_ticket=$monto_apuesta*0.01667;
        if($cont==17) $ap_ticket=$monto_apuesta*0.066;
        if($cont==18) $ap_ticket=$monto_apuesta*0.066;
        if($cont==19) $ap_ticket=$monto_apuesta*0.0333;
        if($cont==20) $ap_ticket=$monto_apuesta*0.0333;
        if($cont==21) $ap_ticket=$monto_apuesta*0.0333;
        if($cont==22) $ap_ticket=$monto_apuesta*0.0333;
        if($cont==23) $ap_ticket=$monto_apuesta*0.01667;
        if($cont==24) $ap_ticket=$monto_apuesta*0.01667;
        if($cont==25) $ap_ticket=$monto_apuesta*0.04;
        if($cont==26) $ap_ticket=$monto_apuesta*0.066;
        if($cont==27) $ap_ticket=$monto_apuesta*0.066;
        return $ap_ticket;
    }

    public static function apuesta_ticket_robin($cont,$monto_apuesta)
    {
        $ap_ticket=1;
        if($cont==1) $ap_ticket=$monto_apuesta*0.1054;
        if($cont==2) $ap_ticket=$monto_apuesta*0.079;
        if($cont==3) $ap_ticket=$monto_apuesta*0.1054;
        if($cont==4) $ap_ticket=$monto_apuesta*0.079;
        if($cont==5) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==6) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==7) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==8) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==9) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==10) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==11) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==12) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==13) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==14) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==15) $ap_ticket=$monto_apuesta*0.0526;
        if($cont==16) $ap_ticket=$monto_apuesta*0.0526;

        return $ap_ticket;
    }

    public static function name_equipos_robin($id_partido1,$id_partido2,$id_partido3,$id_partido4,$id_partido5)
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
            $data= DB::table('robin_hood')->where('id','=',$partidos_id[$k])->first();
            $partido[$k]=$data;
        }
        return $partido;
    }

    public static function name_equipos_senora($id_partido)
    {
        $data= DB::table('senora_soltera')->where('id','=',$id_partido)->first();
        return $data;
    }

    public static function apuest($cont)
    {
        $apt=array();
        if($cont==1)
        {
            $apt['apt1']='1X';
            $apt['apt5']='1';
            return $apt;
        }elseif($cont==2)
        {
            $apt['apt1']='2';
            $apt['apt5']='1';
            return $apt;
        }elseif($cont==3)
        {
            $apt['apt1']='1X';
            $apt['apt5']='X';
            return $apt;
        }elseif($cont==4)
        {
            $apt['apt1']='2';
            $apt['apt5']='X';
            return $apt;
        }elseif($cont==5)
        {
            $apt['apt1']='1X';
            $apt['apt5']='0 a 1';
            return $apt;
        }elseif($cont==6)
        {
            $apt['apt1']='1X';
            $apt['apt5']='1 a 2';
            return $apt;
        }elseif($cont==7)
        {
            $apt['apt1']='1X';
            $apt['apt5']='0 a 2';
            return $apt;
        }elseif($cont==8)
        {
            $apt['apt1']='1X';
            $apt['apt5']='0 a 3';
            return $apt;
        }elseif($cont==9)
        {
            $apt['apt1']='1X';
            $apt['apt5']='1 a 3';
            return $apt;
        }elseif($cont==10)
        {
            $apt['apt1']='1X';
            $apt['apt5']='2 a 3';
            return $apt;
        }elseif($cont==11)
        {
            $apt['apt1']='2';
            $apt['apt5']='0 a 1';
            return $apt;
        }elseif($cont==12)
        {
            $apt['apt1']='2';
            $apt['apt5']='1 a 2';
            return $apt;
        }elseif($cont==13)
        {
            $apt['apt1']='2';
            $apt['apt5']='0 a 2';
            return $apt;
        }elseif($cont==14)
        {
            $apt['apt1']='2';
            $apt['apt5']='0 a 3';
            return $apt;
        }elseif($cont==15)
        {
            $apt['apt1']='2';
            $apt['apt5']='1 a 3';
            return $apt;
        }elseif($cont==16)
        {
            $apt['apt1']='2';
            $apt['apt5']='2 a 3';
            return $apt;
        }
    }
}

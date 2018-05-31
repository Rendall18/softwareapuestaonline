<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
class Usuario extends Model
{
    public static function sig_nup($data){
        
        $data2= DB::table('usuario')->where([
            ['email','=',$data['email']]
        ])->get();

        if(count($data2)>0)
                return 0;
        else
        {
            $ret=DB::table('usuario')->insert([
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'email' => $data['email'],
                'clave' => $data['password'],
                'ip' => $data['ip'],
                'sesion' => $data['sesion'],
                'fecha_registro' => $data['fecha_registro']
            ]);
        }
        if($ret>0)
            return 1;
        else
            return -1;

    }

    public static function sig_nin($request)
    {
        $data2= DB::table('usuario')->where([
            ['email','=',$request->input('email')],
            ['clave','=',$request->input('clave')],
        ])->get();

        if(count($data2)>0){
            $sessi=1;
            $data3=DB::table('usuario')
            ->where('email',$request->input('email'))
            ->update(['ip' =>$request->ip(),'sesion' =>$sessi]);
            if(count($data3)>0)
                return 1;
            else
                return -1;
        }else
            return 0;
    }

    public static function user_sesion($ip)
    {
        $uss=array();
        $data2= DB::table('usuario')->where([
            ['ip','=',$ip],
            ['sesion','=',1]
        ])->get();
        if(count($data2)>0)
        {
            $uss['usuario']=$data2;
            return $uss;
        }else{
            $uss['usuario'][0]['id']='';
            $uss['usuario'][0]['nombre']='';
            $uss['usuario'][0]['apellido']='';
            $uss['usuario'][0]['email']='';
            $uss['usuario'][0]['clave']='';
            $uss['usuario'][0]['ip']='';
            $uss['usuario'][0]['sesion']=0;
            return $uss;
        }
    }

    public static function user_logout($ip)
    {
            $sessi=0;
            $data3=DB::table('usuario')
            ->where('ip',$ip)
            ->update(['sesion' =>$sessi]);
            if(count($data3)>0)
                return 1;
            else
                return -1;
    }

    
        
}

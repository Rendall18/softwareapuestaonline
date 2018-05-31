<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
class Email extends Model
{
    public static function random_password()  
    {  
        $longitud = 8; // longitud del password  
        $pass = substr(md5(rand()),0,$longitud);  
        return($pass); // devuelve el password   
    }

    public static function actualizacion_clave($email,$clave)  
    {  
       $respuesta= DB::table('usuario')
            ->where('email', '=', $email)
            ->update(['clave' => $clave]);
        return $respuesta;
    }

}

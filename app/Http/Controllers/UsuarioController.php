<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Usuario;
use App\Mail\Bienvenido;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    public static function usuario_signup(Request $request)
    {
        $data= array();
        $data['nombre']=$request->input('nombre');
        $data['apellido']=$request->input('apellido');
        $data['email']=$request->input('email');
        $data['password']=$request->input('clave');
        $data['ip']=$request->ip();
        $data['sesion']=false;
        $data['fecha_registro']=date('Y-m-d');
        Mail::to($data['email'])->send(new Bienvenido());
        return response()->json(Usuario::sig_nup($data));
    }

    public static function usuario_signin(Request $request)
    {
        return response()->json(Usuario::sig_nin($request));
    }

    public static function usuario_sesion(Request $request)
    {
        return response()->json(Usuario::user_sesion($request->ip()));
    }

    public static function usuario_logout(Request $request)
    {
        return response()->json(Usuario::user_logout($request->ip()));
    }
}

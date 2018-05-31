<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Email;
use App\Mail\NuevaClave;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function send($correo)
    {
        
        $objDemo = new \stdClass();
        $objDemo->nueva_clave = Email::random_password();
        $objDemo->email = $correo;
        $estado = Email::actualizacion_clave($objDemo->email,$objDemo->nueva_clave);
        if($estado>0)
        {
            Mail::to($objDemo->email)->send(new NuevaClave($objDemo));
            return 'Email enviado exitosamente';
        }else{
            return 'Ocurrio un error';
        }

    }
}

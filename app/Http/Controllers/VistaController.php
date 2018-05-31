<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Vista;
class VistaController extends Controller
{
    public function equipos()
    {
        return view('Partidos.partido');
    }

     public function registrar_equipos(Request $request)
    {   
        
        $status=Vista::registrar($request);
        return view('Partidos.partido')->with('status', $status);
    }
}

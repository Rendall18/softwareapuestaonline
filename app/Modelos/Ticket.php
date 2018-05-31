<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
class Ticket extends Model
{
   public static function lista_tickets()
   {
       $partidos = DB::table('ticket')->get();
       $tickets['Tikets']=$partidos;
         return $tickets;
   }
   public static function detalles_tickets($id)
   {
       $partidos = DB::table('detalles_ticket')->where('id_ticket','=',$id)->get();
       $tickets['Detalles_Tiket']=$partidos;
         return $tickets;
   }
}

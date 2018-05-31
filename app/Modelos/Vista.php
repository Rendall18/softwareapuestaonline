<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use DB;
class Vista extends Model
{
    public static function registrar($partido)
    {
        $nombre_betfair=$partido->nombre_betfair;
        $nombre_espn=$partido->nombre_espn;
        $url_espn=$partido->url_espn;

        if(!$nombre_betfair)
        {
            $nombre_betfair="";
        }
        $data= DB::table('equipos')->where([
            ['nombre_italiano','=',$nombre_espn],
            ['enlace','=',$url_espn]
        ])->get();
        
        if(count($data)>0)
                $ret=-1;
        else{
                $ret=DB::table('equipos')->insertGetId([
                    'nombre_espanol' => $nombre_betfair,
                    'nombre_italiano' => $nombre_espn,
                    'enlace' => $url_espn
                ]);
            }
        return $ret;
    }
}

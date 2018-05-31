
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Exportar Excel</title>
    </head>
    <body>
    
        <table>
            <tr>
                <td></td>
                <td ><h5>SOFTWARE DE APUESTAS ONLINE - MULTIPLICADOR lOCO</h5></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                
            </tr>
            <tr>
            </tr>
            <tr>
                <td style='text-align: center;'><h5>PARTIDO</h5></td>

                <td height="15" width="15" style='text-align: center;'><h5>TIPO APUESTA</h5></td>
                
                <td style='text-align: center;'><h5>LOGRO</h5></td>
            
                <td height="15" width="15" style='text-align: center;'><h5>FECHA</h5></td>
                
                <td style='text-align: center;'><h5>RESULTADO</h5></td>

                <td style='text-align: center;'><h5>ESTADO</h5></td>

                <td height="15" width="15" style='text-align: center;'><h5>ACUMULADO</h5></td>
                <td></td>
              
            </tr>
           
           
            @foreach($Multiplicador as $loco)
                <tr>
                    <td height="15" width="35" style='text-align: center;'>{{$loco['equipo_local']}} - {{$loco['equipo_visitante']}}</td>
                    
                    @if($loco['tipo_logro']==1)
                        <td height="15" width="20" style='text-align: center;'>{{'Over 0.5'}}</td>
                    @elseif($loco['tipo_logro']==0)
                        <td height="15" width="20" style='text-align: center;'>{{'1X'}}</td>
                    @elseif($loco['tipo_logro']==2)
                        <td height="15" width="20" style='text-align: center;'>{{'Under 6.5'}}</td>
                    @else
                        <td height="15" width="12" style='text-align: center;'>{{''}}</td>
                    @endif
                    <td height="15" width="12" style='text-align: center;'>{{$loco['logro']}}</td>

                    <td height="15" width="12" style='text-align: center;'>{{$loco['fecha']}}</td>

                    <td height="15" width="12" style='text-align: center;'>{{$loco['resultado']}}</td>
                    @if($loco['estado']=='Ganador')
                        <td height="15" width="12" style='text-align: center; color:#008000'>{{$loco['estado']}}</td>
                    @elseif($loco['estado']=='Aplazado')
                        <td height="15" width="12" style='text-align: center; color:#696969'>{{$loco['estado']}}</td>
                    @else
                        <td height="15" width="12" style='text-align: center; color:#FF0000'>{{$loco['estado']}}</td>
                    @endif
                    <td height="15" width="12" style='text-align: center;'>{{str_limit($loco['acumulativo'], 6, '')}}</td>
                    
                     </tr>

			@endforeach

             
           
        </table>
    </body>
</html>
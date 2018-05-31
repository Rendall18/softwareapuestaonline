<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets', 'TicketController@get_tickets');

Route::post('/ingresar', 'VistaController@registrar_equipos');

Route::get('/registrar/equipos', 'VistaController@equipos');

Route::get('/info/{dias}', 'PruebaController@get_info');


Route::get('/tickets/{id}', 'TicketController@get_detalles_tickets');

Route::get('/robin/{dias}','PruebaController@get_partidos_robin');

Route::get('/info/partidos/{dias}', 'PruebaController@get_partidos');

Route::get('/senora/{dias}', 'PruebaController@get_partidos_senora');

route::get('exportarexcel/{monto}/{dias}/{tipo}','ExcelController@exportarExcel');


Route::get('/resultado/{dia}/{mes}/{ano}', 'ResultadoController@post_resultado');

//Route::get('/reporte/{id1}/{id2}/{id3}/{id4}/{id5}', 'PruebaController@reporte');
Route::get('/reporte/{id1}/{id2}/{id3}/{id4}/{id5}/{monto_apuesta}', 'PDFController@reporte');
Route::get('/reporte/robin/{id1}/{id2}/{id3}/{id4}/{id5}/{monto_apuesta}', 'PDFRController@reporte_robin');



Route::get('/equipos/{id1}/{id2}/{id3}/{id4}/{id5}', 'PruebaController@equipos');

Route::post('/usuario', 'UsuarioController@usuario_signup');
Route::post('/login', 'UsuarioController@usuario_signin');
Route::post('/sesion', 'UsuarioController@usuario_sesion');
Route::post('/logout', 'UsuarioController@usuario_logout');

Route::get('/sendemail/{email}','EmailController@send');


Route::get('/multiplicador/{day}', 'PruebaController@get_multiplicador');


Route::get('/scraping','ScrapingController@get_scraping');

Route::get('/reporte/senora/normal/{local}/{visitante}/{monto}/{pronostico1}/{pronostico2}/{pronostico3}/{pronostico4}/{pronostico5}/{pronostico6}/{cuota1}/{cuota2}/{cuota3}/{cuota4}/{cuota5}/{cuota6}/{porcentaje1}/{porcentaje2}/{porcentaje3}/{porcentaje4}/{porcentaje5}/{porcentaje6}/{apuesta1}/{apuesta2}/{apuesta3}/{apuesta4}/{apuesta5}/{apuesta6}/{ganancia1}/{ganancia2}/{ganancia3}/{ganancia4}/{ganancia5}/{ganancia6}/{ganancia_neta1}/{ganancia_neta2}/{ganancia_neta3}/{ganancia_neta4}/{ganancia_neta5}/{ganancia_neta6}/{porcentaje_ganancia1}/{porcentaje_ganancia2}/{porcentaje_ganancia3}/{porcentaje_ganancia4}/{porcentaje_ganancia5}/{porcentaje_ganancia6}/{no1}/{no2}/{no3}/{no4}/{no5}/{no6}','PDFSSController@reporte_senora');
Route::get('/reporte/senora/balanceado/{local}/{visitante}/{monto}/{pronostico1}/{pronostico2}/{pronostico3}/{pronostico4}/{pronostico5}/{pronostico6}/{pronostico7}/{cuota1}/{cuota2}/{cuota3}/{cuota4}/{cuota5}/{cuota6}/{cuota7}/{porcentaje1}/{porcentaje2}/{porcentaje3}/{porcentaje4}/{porcentaje5}/{porcentaje6}/{porcentaje7}/{apuesta1}/{apuesta2}/{apuesta3}/{apuesta4}/{apuesta5}/{apuesta6}/{apuesta7}/{ganancia1}/{ganancia2}/{ganancia3}/{ganancia4}/{ganancia5}/{ganancia6}/{ganancia7}/{ganancia_neta1}/{ganancia_neta2}/{ganancia_neta3}/{ganancia_neta4}/{ganancia_neta5}/{ganancia_neta6}/{ganancia_neta7}/{porcentaje_ganancia1}/{porcentaje_ganancia2}/{porcentaje_ganancia3}/{porcentaje_ganancia4}/{porcentaje_ganancia5}/{porcentaje_ganancia6}/{porcentaje_ganancia7}/{no1}/{no2}/{no3}/{no4}/{no5}/{no6}/{no7}','PDFSSController@reporte_senora_balanceado');
/*
http://localhost/Laravel/Scraping/Apocalipsis/public/reporte/senora/normal/
Levante/Barcelona FC/100/
1X/0 a 1/0 a 2/0 a 3/1 a 2/1 a 3/
3.5/11/8/9.5/8/9/
7.14/22.45/16.33/19.39/16.33/18.37/
1.43/4.49/3.27/3.88/3.27/3.67/
5/49.39/26.12/36.84/26.12/33.06/
3.57/44.9/22.85/32.96/22.85/29.39/
25/246.95/130.6/184.2/130.6/165.3/
false/false/false/false/false/false

http://localhost/Laravel/Scraping/Apocalipsis/public/reporte/senora/normal/Levante/Barcelona FC/100/1X/0 a 1/0 a 2/0 a 3/1 a 2/1 a 3/3.5/11/8/9.5/8/9/7.14/22.45/16.33/19.39/16.33/18.37/1.43/4.49/3.27/3.88/3.27/3.67/5/49.39/26.12/36.84/26.12/33.06/3.57/44.9/22.85/32.96/22.85/29.39/25/246.95/130.6/184.2/130.6/165.3/false/false/false/false/false/true



http://localhost/Laravel/Scraping/Apocalipsis/public/reporte/senora/balanceado/
Levante/Barcelona FC/100/
X/1 a 0/2 a 0/2 a 1/0 a 1/0 a 2/1 a 2/
3.5/11/8/9.5/8/9/8/
7.14/22.45/16.33/19.39/16.33/18.37/13.34/
1.43/4.49/3.27/3.88/3.27/3.67/3.65/
5/49.39/26.12/36.84/26.12/33.06/12.34/
3.57/44.9/22.85/32.96/22.85/29.39/22.56/
25/246.95/130.6/184.2/130.6/165.3/30.43/
false/false/false/false/false/false/false

http://localhost/Laravel/Scraping/Apocalipsis/public/reporte/senora/balanceado/Levante/Barcelona FC/100/X/1 a 0/2 a 0/2 a 1/0 a 1/0 a 2/1 a 2/3.5/11/8/9.5/8/9/8/7.14/22.45/16.33/19.39/16.33/18.37/13.34/1.43/4.49/3.27/3.88/3.27/3.67/3.65/5/49.39/26.12/36.84/26.12/33.06/12.34/3.57/44.9/22.85/32.96/22.85/29.39/22.56/25/246.95/130.6/184.2/130.6/165.3/30.43/false/false/false/false/false/false/true

*/




/*DB_DATABASE=u899460795_histo
DB_USERNAME=u899460795_itali
DB_PASSWORD=18011993roco*/

/*
ICE50 
MIGHTYSALEH25
QUANTECH3000
GOOGCOM294
TWEETR562
FACEPAGE1920
FACEGROUP900
POINTYNEWYEAR50
REDDITSUB345
KINGY25
POINTSPRIZES25
BEERMONEY3573
FEARLESS50
DELTA100
RANKER25
LACUNA75
COMET50
SHADOW25
*/
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ScrapingController extends Controller
{
    public function get_scraping()
    {
        /*$client = new Client();
        $crawler = $client->request('GET','http://www.ampidf.com.mx/es/directorioprofesionalesinmobiliarios');
        $inlineContactStyles = 'background-color: #DDEDC2;background-image: url("/images/BoxNoticia.jpg");background-position: center top; overflow:hidden; height:100%;margin-bottom:10px;';
        $contact= $crawler->filter("[style='$inlineContactStyles']")->first();
        
        dd($contact->html());*/

        $html = new \Htmldom('https://productos.ofik.com/el-conjunto-secretarial-trot-pera-negro.html');
        $instancia=$html->find('div[class="col-main"]');
        $bloques_fecha=count($instancia);   
       // $instancia[0]->childNodes(0)->childNodes(0)->plaintext
        dd($instancia[0]->childNodes(0)->childNodes(0)->childNodes(0)->childNodes(2)->childNodes(0)->childNodes(0)->plaintext);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;
use App\Models\Cidade;

class LerEstadosController extends Controller
{
    public function save(){
        $response = json_decode(file_get_contents("/var/www/html/gerenciador-orcamento/public/mocks/estados.json"), true);

        //Cidade::truncate();
       //Estado::truncate();

        foreach($response['estados'] as $estado){
            $e = new Estado();
            $e->uf = $estado['sigla'];
            $e->nome = $estado['nome'];
            //$e->save();

            foreach($estado['cidades'] as $cidade){
                $c = new Cidade();
                $c->nome = $cidade;
                $c->estado_id = $e->id;
                //$c->save();
            }
        }

        dd("Script finalizado");
    }
}

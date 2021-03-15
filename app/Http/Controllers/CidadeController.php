<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;

class CidadeController extends Controller
{

    public function find(Request $data){
        $cidades = Cidade::where("estado_id", $data->id)->orderBy("nome", "asc")->get()->toJson();

        return $cidades;
    }
}

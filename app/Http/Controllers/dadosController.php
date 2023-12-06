<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class dadosController extends Controller
{
    public function obterDadosPeso(){
        $caminhoArquivo = 'public/derived_com.google.weight_com.google.android.g.json';
        $dados = json_decode(Storage::get($caminhoArquivo), true);

        return response()->json($dados);
    }
}

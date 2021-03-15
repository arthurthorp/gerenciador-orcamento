<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\FormaPagamento;
use App\Models\LinhaOrcamento;
use App\Models\Orcamento;
use App\Models\Status;
use Exception;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orcamentos = Orcamento::where("user_id", Auth::user()->id)->orderBy("status_id", "desc")->paginate(10);

        return view("admin.orcamento.index")->with("orcamentos", $orcamentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = Status::orderBy("nome", "asc")->get();
        $data['clientes'] = Cliente::where("user_id", Auth::user()->id)->orderBy("nome", "asc")->get();
        $data['formas_pagamento'] = FormaPagamento::orderBy("nome", "asc")->get();
        $data['max'] = (Orcamento::selectRaw("MAX(numero) as numero")->where("user_id", Auth::user()->id)->get()->pluck('numero')[0]) + 1;


        return view("admin.orcamento.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orcamento = new Orcamento();
        $orcamento->numero = $request->numero;
        $orcamento->cliente_id = $request->cliente;
        $orcamento->status_id = $request->status;
        $orcamento->user_id = Auth::user()->id;
        $orcamento->forma_pagamento_id = $request->forma_pagamento;
        $orcamento->garantia = $request->garantia;
        $orcamento->validade = $request->validade;
        $orcamento->data_emissao = $request->data_emissao;
        $orcamento->informacoes = $request->informacao;

        try{
            $orcamento->save();
        }catch(Exception $e){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "Ocorreu um erro ao cadastrar o orçamento.");
            return redirect()->route("orcamentos");
        }

        foreach($request->descricao as $key => $descricao){
            $linha = new LinhaOrcamento();
            $linha->descricao = $descricao;
            $linha->orcamento_id = $orcamento->id;
            $linha->valor_unitario = $request->valor_unitario[$key];
            $linha->quantidade = $request->quantidade[$key];

            try{
                $linha->save();
            }catch(Exception $e){
                LinhaOrcamento::where("orcamento_id", $orcamento->id)->delete();
                $orcamento->delete();
                $request->session()->flash("type", "error");
                $request->session()->flash("message", "Ocorreu um erro ao cadastrar o item ".($key+1).".");
                return redirect()->route("orcamentos");
            }
        }

        $request->session()->flash("type", "success");
        $request->session()->flash("message", "Orçamento cadastrado com sucesso.");
        return redirect()->route("orcamentos");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $orcamento = Orcamento::where("id",$id)->where("user_id", Auth::user()->id)->first();
        if(!$orcamento){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "Você não possui permissão para editar esse orçamento");
            return redirect()->route("orcamentos");
        }
        $title = "Orçamento Nº".$orcamento->numero;
        return view("admin.orcamento.show")->with("orcamento", $orcamento)->with("title", $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $data['status'] = Status::orderBy("nome", "asc")->get();
        $data['clientes'] = Cliente::where("user_id", Auth::user()->id)->orderBy("nome", "asc")->get();
        $data['formas_pagamento'] = FormaPagamento::orderBy("nome", "asc")->get();
        $data['max'] = (Orcamento::selectRaw("MAX(numero) as numero")->where("user_id", Auth::user()->id)->get()->pluck('numero')[0]) + 1;
        $data['orcamento'] = Orcamento::where("id",$id)->where("user_id", Auth::user()->id)->first();

        if(!$data['orcamento']){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "Você não possui permissão para acessar esse orçamento");
            return redirect()->route("orcamentos");
        }

        return view("admin.orcamento.create", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $orcamento = Orcamento::where("id",$id)->where("user_id", Auth::user()->id)->first();
        if(!$orcamento){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "Você não possui permissão para editar esse orçamento");
            return redirect()->route("orcamentos");
        }

        $orcamento->numero = $request->numero;
        $orcamento->cliente_id = $request->cliente;
        $orcamento->status_id = $request->status;
        $orcamento->user_id = Auth::user()->id;
        $orcamento->forma_pagamento_id = $request->forma_pagamento;
        $orcamento->garantia = $request->garantia;
        $orcamento->validade = $request->validade;
        $orcamento->data_emissao = $request->data_emissao;
        $orcamento->informacoes = $request->informacao;

        try{
            $orcamento->save();
        }catch(Exception $e){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "Ocorreu um erro ao cadastrar o orçamento. ");
            return redirect()->route("orcamentos");
        }

        LinhaOrcamento::where("orcamento_id", $orcamento->id)->delete();
        foreach($request->descricao as $key => $descricao){
            $linha = new LinhaOrcamento();
            $linha->descricao = $descricao;
            $linha->orcamento_id = $orcamento->id;
            $linha->valor_unitario = $request->valor_unitario[$key];
            $linha->quantidade = $request->quantidade[$key];

            try{
                $linha->save();
            }catch(Exception $e){
                LinhaOrcamento::where("orcamento_id", $orcamento->id)->delete();
                $orcamento->delete();
                $request->session()->flash("type", "error");
                $request->session()->flash("message", "Ocorreu um erro ao cadastrar o item ".($key+1).".");
                return redirect()->route("orcamentos");
            }
        }

        $request->session()->flash("type", "success");
        $request->session()->flash("message", "Orçamento cadastrado com sucesso.");
        return redirect()->route("orcamentos");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $orcamento = Orcamento::where("id",$id)->where("user_id", Auth::user()->id)->first();
        if(!$orcamento){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "Você não possui permissão para remover esse orçamento");
            return redirect()->route("orcamentos");
        }

        LinhaOrcamento::where("orcamento_id", $orcamento->id)->delete();
        $orcamento->delete();

        $request->session()->flash("type", "success");
        $request->session()->flash("message", "Orçamento removido com sucesso.");
        return redirect()->route("orcamentos");
    }
}

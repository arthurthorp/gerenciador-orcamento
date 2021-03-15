<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Orcamento;
use Exception;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::where("user_id", Auth::user()->id)->orderBy("nome", "asc")->paginate(10);
        return view("admin.clientes.index")->with("clientes", $clientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Estado::orderBy("nome", "asc")->get();
        return view("admin.clientes.create")->with("estados", $estados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome_cliente' => 'required',
            'cnpj' => 'required',
            'telefone' => 'required',
            'cidade' => 'required',
            'endereco' => 'required',
            'cep' => 'required',
        ]);

        $exist = Cliente::where("cnpj", $request->cnpj)->where("user_id", Auth::user()->id)->count();

        if($exist){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "CNPJ já cadastrado. Tente utilizar outro.");
            return redirect()->route("clientes");
        }

        try{
            $cliente = new Cliente();
            $cliente->nome = $request->nome_cliente;
            $cliente->cnpj = $request->cnpj;
            $cliente->telefone = $request->telefone;
            $cliente->cidade_id = $request->cidade;
            $cliente->endereco = $request->endereco;
            $cliente->cep = $request->cep;
            $cliente->user_id = Auth::user()->id;
            $cliente->save();

        }catch(Exception $e){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "Ocorreu um erro ao cadastrar o cliente.");
        }

        $request->session()->flash("type", "success");
        $request->session()->flash("message", "Cliente cadastrado com sucesso.");
        return redirect()->route("clientes");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['cliente'] = Cliente::findOrFail($id);
        $data['title'] = "Cliente - ".$data['cliente']->nome;
        return view("admin.clientes.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['cliente'] = Cliente::findOrFail($id);
        $data['estados'] = Estado::orderBy("nome", "asc")->get();
        $data['title'] = "Cliente - ".$data['cliente']->nome;
        return view("admin.clientes.create", $data);
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
        $request->validate([
            'nome_cliente' => 'required',
            'cnpj' => 'required',
            'telefone' => 'required',
            'cidade' => 'required',
            'endereco' => 'required',
            'cep' => 'required',
        ]);

        $exist = Cliente::where("cnpj", $request->cnpj)->where("user_id", Auth::user()->id)->where("id", "!=" , $id)->count();

        if($exist){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "CNPJ já cadastrado. Tente utilizar outro.");
            return redirect()->route("clientes");
        }

        try{
            $cliente = Cliente::find($id);
            $cliente->nome = $request->nome_cliente;
            $cliente->cnpj = $request->cnpj;
            $cliente->telefone = $request->telefone;
            $cliente->cidade_id = $request->cidade;
            $cliente->endereco = $request->endereco;
            $cliente->cep = $request->cep;
            $cliente->save();

        }catch(Exception $e){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "Ocorreu um erro ao alterar o cliente.");
        }

        $request->session()->flash("type", "success");
        $request->session()->flash("message", "Cliente atualizado com sucesso.");
        return redirect()->route("clientes");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $cliente = Cliente::where("id", $id)->where("user_id", Auth::user()->id)->first();
        if(!$cliente){
            $request->session()->flash("type", "error");
            $request->session()->flash("message", "Você não tem permissão para remover este cliente");
            return redirect()->route("clientes");
        }

        Orcamento::destroy( Orcamento::select("id")->where("cliente_id")->get()->pluck("id")->toArray());

        $cliente->delete();

        $request->session()->flash("type", "success");
        $request->session()->flash("message", "Cliente removido com sucesso.");
        return redirect()->route("clientes");
    }
}

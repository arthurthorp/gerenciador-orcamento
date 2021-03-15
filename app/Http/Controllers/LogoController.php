<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = User::find(Auth::user()->id);

        if($request->logo != null){
            if(!$request->file('logo')->isValid()){
                $request->session()->flash("type", "error");
                $request->session()->flash("message", "Arquivo inválido");
                return back();
            }
            $arquivo = $request->file('logo');
            $nome = $arquivo->getClientOriginalName();
            $extension = $arquivo->getMimeType();

            if($user->logo != ""){
                Storage::delete($user->logoUrl());
            }

            $path = $arquivo->storeAs( 'public/logo', $nome);
            $user->logo = $nome;
        }
        $user->phone = $request->telefone;
        $user->save();

        $request->session()->flash("type", "success");
        $request->session()->flash("message", "Logo e telefone atualizado com sucesso");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

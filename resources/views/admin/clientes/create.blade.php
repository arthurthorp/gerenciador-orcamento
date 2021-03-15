<x-admin-layout>
    @if(session('message'))
        <x-toast-alert :type="session('type')">
            <span class="leading-9 text-lg">
                {{session('message')}}
            </span>
        </x-toast-alert>
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title ?? "Clientes" }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-6 bg-white border-b border-gray-200">
                    <a href="{{route('clientes')}}" class="text-blue-500 hover:underline flex gap-2">
                        <svg class="w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                          </svg>Voltar
                    </a>

                </div>
                <form @if(isset($cliente)) action="{{route('clientes.update', $cliente->id)}}" @else action="{{route('clientes.store')}}" @endif method="post">
                    @csrf
                    @if(isset($cliente))
                        @method('PUT')
                    @endif
                    <div class=" grid grid-cols-1">
                        <div class="p-6 flex flex-col justify-center w-full">
                            <h3 class="text-lg py-6 pb-3 border-b border-gray-200 mb-6">Dados cadastrais</h3>
                            <div class="grid grid-cols-6 gap-6 mb-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="nome_cliente" value="{{ __('Nome*') }}" />
                                    <x-input id="nome_cliente" name="nome_cliente" type="text" value="{{@$cliente->nome}}" class="mt-1 block w-full" required autocomplete="nome_cliente" />
                                    <x-jet-input-error for="nome_cliente" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="cnpj" value="{{ __('CNPJ*') }}" />
                                    <x-input id="cnpj" name="cnpj" type="text" class="mt-1 block w-full" value="{{@$cliente->cnpj}}" required autocomplete="cnpj"  minlength="18" />
                                    <x-jet-input-error for="cnpj" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="telefone" value="{{ __('Telefone*') }}" />
                                    <x-input id="telefone" name="telefone" type="text" class="mt-1 block w-full" value="{{@$cliente->telefone}}" required autocomplete="telefone" minlength="15" />
                                    <x-jet-input-error for="telefone" class="mt-2" />
                                </div>
                            </div>

                            <h3 class="text-lg py-6 pb-3 border-b border-gray-200 mb-6">Endereço</h3>
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="estado" value="{{ __('Estado*') }}" />
                                    <x-select id="estado" name="estado" required>
                                        <option value=""></option>
                                        @foreach($estados as $estado)
                                            <option value="{{$estado->id}}" @if(isset($cliente) && $cliente->cidade->estado->id == $estado->id) selected @endif>{{ $estado->nome}} - {{$estado->uf}}</option>
                                        @endforeach
                                    </x-select>
                                    <x-jet-input-error for="nome_cliente" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="cidade" value="{{ __('Cidade*') }}" />
                                    <x-select id="cidade" name="cidade" required>
                                        @if(isset($cliente))
                                            @foreach ($cliente->cidade->estado->cidades as $cidade)
                                                <option value="{{$cidade->id}}" @if($cliente->cidade_id == $cidade->id) selected @endif>{{$cidade->nome}}</option>
                                            @endforeach
                                        @else
                                            <option value="">Selecione um estado primeiro</option>
                                        @endif
                                    </x-select>
                                    <x-jet-input-error for="cidade" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="endereco" value="{{ __('Endereço*') }}" />
                                    <x-input id="endereco" name="endereco" required type="text" value="{{@$cliente->endereco}}" class="mt-1 block w-full" autocomplete="endereco" />
                                    <x-jet-input-error for="endereco" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="cep" value="{{ __('CEP*') }}" />
                                    <x-input id="cep" name="cep" required type="text" class="mt-1 block w-full" value="{{@$cliente->cep}}" minlength="9" autocomplete="cep" />
                                    <x-jet-input-error for="cep" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 p-6 pb-0">
                        <x-button type="submit">
                            Salvar
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $("#estado").on("change", function(){
            var estado = $(this).val();

            if(estado != ""){
                $.ajax({
                    method: "GET",
                    url: "{{route('cidades.find')}}",
                    data: {
                        id: estado
                    }
                })
                .success(function(msg){
                    $("#cidade").empty();
                    if(JSON.parse(msg))
                        JSON.parse(msg).forEach( function(cidade){
                            $("#cidade").append("<option value='"+cidade.id+"'>"+cidade.nome+"</option>")
                        })
                })
            }
        })
    </script>
</x-admin-layout>

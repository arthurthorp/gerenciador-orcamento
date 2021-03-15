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

                <div class=" grid grid-cols-1">
                    <div class="p-6 flex flex-col justify-center w-full">
                        <h3 class="text-lg py-6 pb-3 border-b border-gray-200 mb-6">Dados cadastrais</h3>
                        <div class="grid grid-cols-6 gap-6 mb-6">
                            <div class="col-span-6 sm:col-span-3">
                                <h3><b>Nome: </b>{{$cliente->nome}}</h3>

                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <h3><b>CNPJ: </b>{{$cliente->cnpj}}</h3>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <h3><b>Telefone: </b>{{$cliente->telefone}}</h3>
                            </div>
                        </div>

                        <h3 class="text-lg py-6 pb-3 border-b border-gray-200 mb-6">Endereço</h3>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <h3><b>Estado: </b>{{$cliente->cidade->estado->nome}}</h3>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <h3><b>Cidade: </b>{{$cliente->cidade->nome}}</h3>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <h3><b>Endereço: </b>{{$cliente->endereco}}</h3>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <h3><b>CEP: </b>{{$cliente->cep}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 p-6 pb-0">
                    <a href="{{route('clientes.edit', $cliente->id)}}">
                        <x-button type="button">
                            Editar
                        </x-button>
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>

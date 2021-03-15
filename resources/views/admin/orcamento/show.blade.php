<x-admin-layout title={{$title}}>
    @if(session('message'))
        <x-toast-alert :type="session('type')">
            <span class="leading-9 text-lg">
                {{session('message')}}
            </span>
        </x-toast-alert>
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title ?? "Orçamentos" }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <button onclick="imprimir();" class="mb-5 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-auto mr-0 bg-green-500 hover:bg-green-700">
                <svg class="w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span class="ml-3">Imprimir</span>
            </button>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-8">
                <page size="A4" id="printer" style="width: 100%">
                    <div class="p-6 flex flex-col justify-center w-full border-b-2 border-gray-300">
                        <div class=" grid grid-cols-1">
                            <h4 class="font-bold text-right text-xl">Orçamento N°{{$orcamento->numero}}</h4>
                        </div>

                        <div class="grid grid-cols-6 gap-6 mb-6 d-flex">
                            <div class="col-span-6 sm:col-span-3">
                                <img class="w-48" src="{{Auth::user()->logoUrl()}}" alt="Logo">
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-12 ">
                                <p class="text-right">{{Auth::user()->email}}</p>
                                <p class="text-right">{{Auth::user()->phone}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col justify-center w-full border-b-2 border-gray-300">

                        <div class="grid grid-cols-6 gap-6 mb-12 d-flex">
                            <div class="col-span-6 sm:col-span-3">
                                <p class="text-left"><span class="font-bold">Data Emissão: </span>{{date("d/m/Y", strtotime($orcamento->data_emissao))}}</p>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <p class="text-right"><span class="font-bold">Situação do Orçamento: </span>{{$orcamento->status->nome}}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-6 gap-6 d-flex">
                            <div class="col-span-6 sm:col-span-3">
                                <p class="text-left"><span class="font-bold">Dados do Cliente</span></p>
                                <p class="text-left"><span class="font-bold">Nome: </span>{{$orcamento->cliente->nome}}</p>

                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <p class="text-right"><span class="font-bold"></span></p>
                                <p class="text-right"><span class="font-bold">Telefone: </span>{{$orcamento->cliente->telefone}}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-6 gap-6 mb-12 d-flex">
                            <div class="col-span-6 sm:col-span-6">
                                <p class="text-left"><span class="font-bold">Endereço: </span>{{$orcamento->cliente->endereco." - ".$orcamento->cliente->cidade->nome."/".$orcamento->cliente->cidade->estado->nome." - CEP:".$orcamento->cliente->cep}}</p>

                            </div>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col justify-center w-full border-b-2 border-gray-300">
                        <table>
                            <tr>
                                <th class="text-left">Descrição</th>
                                <th class="text-right">Valor Unitário</th>
                                <th class="text-right">Quantidade</th>
                                <th class="text-right">Total</th>
                            </tr>

                            @foreach($orcamento->linhas as $linha)
                                <tr>
                                    <td>{{$linha->descricao}}</td>
                                    <td class="text-right">R$ {{number_format($linha->valor_unitario, 2, ",", ".")}}</td>
                                    <td class="text-right">{{$linha->quantidade}}</td>
                                    <td class="text-right">{{number_format(($linha->valor_unitario * $linha->quantidade), 2, ",", ".")}}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td class="font-bold pt-8" colspan="3">Total Geral</td>
                                <td class="text-right font-bold pt-8">{{$orcamento->valorTotal()}}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="p-6 flex flex-col justify-center w-full border-b-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-6">
                                <p class="text-left"><span class="font-bold">Outras informações</span></p>
                                <p>{{$orcamento->informacoes}}</p>
                            </div>
                            <div class="col-span-6 sm:col-span-6">
                                <p class="text-left"><span class="font-bold">Orçamento válido até: {{date("d/m/Y", strtotime($orcamento->validade))}}</span></p>
                                <p class="text-left"><span class="font-bold">Garantia até: {{date("d/m/Y", strtotime($orcamento->garantia))}}</span></p>
                                <p class="text-left"><span class="font-bold">Forma de Pagamento: {{date("d/m/Y", strtotime($orcamento->formaPagamento->nome))}}</span></p>
                            </div>
                        </div>
                    </div>
                </page>
            </div>
        </div>
    </div>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printer, #printer * {
                visibility: visible;
            }
            #printer {
                position: absolute;
                left: 0;
                top: 0;
            }
            #printer .bg-white{
                box-shadow: none;
            }

            .d-flex {
                display: flex;
                justify-content: space-between
            }
            .two {
                column-count: 2;
                -webkit-column-count: 2;
                -moz-column-count: 2;
            }
            .one {
                column-count: 1;
                -webkit-column-count: 1;
                -moz-column-count: 1;
            }
            .print-border{
                border: 0;
            }

            #print-ans{
                color: #000;
            }

            .max-w-7xl {
                width: 100% !important;
            }
        }
    </style>
    <script>
        function imprimir(){
            print('{{route("orcamentos")}}')
        }
    </script>
</x-admin-layout>

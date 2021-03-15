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
            {{ $title ?? "Orçamentos" }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-6 bg-white border-b border-gray-200">
                    <a href="{{route('orcamentos')}}" class="text-blue-500 hover:underline flex gap-2">
                        <svg class="w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                          </svg>Voltar
                    </a>

                </div>
                <form @if(isset($orcamento)) action="{{route('orcamentos.update', $orcamento->id)}}" @else action="{{route('orcamentos.store')}}" @endif method="post">
                    @csrf
                    @if(isset($orcamento))
                        @method('PUT')
                    @endif
                    <div class=" grid grid-cols-1">
                        <div class="p-6 flex flex-col justify-center w-full">
                            <h3 class="text-lg py-6 pb-3 border-b border-gray-200 mb-6">Dados cadastrais</h3>
                            <div class="grid grid-cols-6 gap-6 mb-6">
                                <div class="col-span-6 sm:col-span-1">
                                    <x-jet-label for="numero" value="{{ __('Orçamento número*') }}" />
                                    <x-input id="numero" name="numero" type="number" value="{{@$orcamento->numero ?? $max}}" class="mt-1 block w-full" required  />
                                    <x-jet-input-error for="numero" class="mt-2" />
                                </div>
                            </div>
                            <div class="grid grid-cols-6 gap-6 mb-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <x-jet-label for="cliente" value="{{ __('Cliente*') }}" />
                                    <x-select id="cliente" name="cliente" required>
                                        <option value="" disabled selected></option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{$cliente->id}}" @if(isset($orcamento) && $orcamento->cliente_id == $cliente->id) selected @endif>{{ $cliente->nome}}</option>
                                        @endforeach
                                    </x-select>
                                    <x-jet-input-error for="cliente" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <x-jet-label for="status" value="{{ __('Status*') }}" />
                                    <x-select id="status" name="status" required>
                                        <option value="" disabled selected></option>
                                        @foreach($status as $s)
                                            <option value="{{$s->id}}" @if(isset($orcamento) && $orcamento->status_id == $s->id) selected @endif>{{ $s->nome}}</option>
                                        @endforeach
                                    </x-select>
                                    <x-jet-input-error for="status" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <x-jet-label for="forma_pagamento" value="{{ __('Forma de pagamento*') }}" />
                                    <x-select id="forma_pagamento" name="forma_pagamento" required>
                                        <option value="" disabled selected></option>
                                        @foreach($formas_pagamento as $forma)
                                            <option value="{{$forma->id}}" @if(isset($orcamento) && $orcamento->forma_pagamento_id == $forma->id) selected @endif>{{ $forma->nome}}</option>
                                        @endforeach
                                    </x-select>
                                    <x-jet-input-error for="forma_pagamento" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="garantia" value="{{ __('Garantia*') }}" />
                                    <x-input id="garantia" name="garantia" required type="text" value="{{@$orcamento->garantia}}" class="mt-1 block w-full" autocomplete="garantia" />
                                    <x-jet-input-error for="garantia" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="validade" value="{{ __('Validade*') }}" />
                                    <x-input id="validade" name="validade" required type="date" value="{{@$orcamento->validade}}" class="mt-1 block w-full" />
                                    <x-jet-input-error for="validade" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-jet-label for="data_emissao" value="{{ __('Data de Emissão*') }}" />
                                    <x-input id="data_emissao" name="data_emissao" required type="date" value="{{@$orcamento->data_emissao}}" class="mt-1 block w-full" />
                                    <x-jet-input-error for="data_emissao" class="mt-2" />
                                </div>

                                <div class="col-span-6">
                                    <x-jet-label for="informacao" value="{{ __('Informação adicional') }}" />
                                    <x-textarea name="informacao" id="informacao">{{@$orcamento->informacoes}}</x-textarea>
                                    <x-jet-input-error for="informacao" class="mt-2" />
                                </div>
                            </div>

                            <h3 class="text-lg py-6 pb-3 border-b border-gray-200 mb-6">Itens</h3>
                            <section id="itens">
                                @if(isset($orcamento))
                                    @foreach($orcamento->linhas as $key => $linha)
                                        <div class="grid grid-cols-6 gap-6 item" id="item_{{$key}}">
                                            <div class="col-span-6 sm:col-span-3">
                                                <x-jet-label for="descricao" value="{{ __('Descrição*') }}" />
                                                <x-input id="descricao" name="descricao[]" required value="{{$linha->descricao}}" type="text" class="mt-1 block w-full" />
                                                <x-jet-input-error for="descricao" class="mt-2" />
                                            </div>

                                            <div class="col-span-6 sm:col-span-1">
                                                <x-jet-label for="valor_unitario" value="{{ __('Valor unitário*') }}" />
                                                <x-input id="valor_unitario" name="valor_unitario[]" value="{{$linha->valor_unitario}}" required type="number" step=".01" class="mt-1 block w-full"  />
                                                <x-jet-input-error for="valor_unitario" class="mt-2" />
                                            </div>

                                            <div class="col-span-6 sm:col-span-1">
                                                <x-jet-label for="quantidade" value="{{ __('Quantidade*') }}" />
                                                <x-input id="quantidade" name="quantidade[]" value="{{$linha->quantidade}}" min="1" step="1" required type="number" class="mt-1 block w-full"  />
                                                <x-jet-input-error for="quantidade" class="mt-2" />
                                            </div>

                                            <div class="col-span-6 sm:col-span-1 flex flex-col justify-center mx-auto">
                                                <x-jet-label for="quantidade" value="Remover" />
                                                <span class="cursor-pointer text-red-500 remover mx-auto" data-id="item_{{$key}}" alt="Deletar">
                                                    <svg class="w-8 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="grid grid-cols-6 gap-6 item" id="item_0">
                                        <div class="col-span-6 sm:col-span-3">
                                            <x-jet-label for="descricao" value="{{ __('Descrição*') }}" />
                                            <x-input id="descricao" name="descricao[]" required type="text" value="" class="mt-1 block w-full" />
                                            <x-jet-input-error for="descricao" class="mt-2" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-1">
                                            <x-jet-label for="valor_unitario" value="{{ __('Valor unitário*') }}" />
                                            <x-input id="valor_unitario" name="valor_unitario[]" required type="number" step=".01" class="mt-1 block w-full"  />
                                            <x-jet-input-error for="valor_unitario" class="mt-2" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-1">
                                            <x-jet-label for="quantidade" value="{{ __('Quantidade*') }}" />
                                            <x-input id="quantidade" name="quantidade[]" required type="number" min="0" step="1" class="mt-1 block w-full"  />
                                            <x-jet-input-error for="quantidade" class="mt-2" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-1 flex flex-col justify-center mx-auto">
                                            <x-jet-label for="quantidade" value="Remover" />
                                            <span class="cursor-pointer text-red-500 remover mx-auto" data-id="item_0" alt="Deletar">
                                                <svg class="w-8 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </section>
                            <div class="mt-8">
                                <x-button type="button" id="novo_item">
                                    Novo item
                                </x-button>
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
        $(document).ready(function(){
            $("#novo_item").on("click", function(){
                var qtd = $(".item").length;
                $("#itens").append(`<div class="grid grid-cols-6 gap-6 item mt-6" id="item_${qtd}">
                                        <div class="col-span-6 sm:col-span-3">
                                            <x-jet-label for="descricao" value="{{ __('Descrição*') }}" />
                                            <x-input id="descricao" name="descricao[]" required type="text" value="" class="mt-1 block w-full" />
                                            <x-jet-input-error for="descricao" class="mt-2" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-1">
                                            <x-jet-label for="valor_unitario" value="{{ __('Valor unitário*') }}" />
                                            <x-input id="valor_unitario" name="valor_unitario[]" required type="number" step=".01" class="mt-1 block w-full"  />
                                            <x-jet-input-error for="valor_unitario" class="mt-2" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-1">
                                            <x-jet-label for="quantidade" value="{{ __('Quantidade*') }}" />
                                            <x-input id="quantidade" name="quantidade[]" min="0" step="1" required type="number" class="mt-1 block w-full"  />
                                            <x-jet-input-error for="quantidade" class="mt-2" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-1 flex flex-col justify-center mx-auto">
                                            <x-jet-label for="quantidade" value="Remover" />
                                            <span class="cursor-pointer text-red-500 remover mx-auto" data-id="item_${qtd}" alt="Deletar">
                                                <svg class="w-8 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>`);
            })

            $(document).on("click",".remover", function(){
                if($(".item").length == 1){
                    alert("Não é possível remover o último item da lista")
                }else{
                    var id = $(this).data("id");
                    $("#"+id).remove();
                }

            });
        })
    </script>
</x-admin-layout>

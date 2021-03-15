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
                    <a href="{{route('clientes.create')}}">
                        <x-button>
                            Adicionar cliente
                        </x-button>
                    </a>

                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1">
                    <div class="p-6 flex flex-col justify-center w-full">

                        <table class="border-collapse w-full rounded-t-lg">
                            <thead class="bg-green-500 ">
                              <tr class="">
                                <th class="border-2 border-green-600 px-4 py-2 text-white text-left font-flow">ID</th>
                                <th class="border-2 border-green-600 px-4 py-2 text-white text-left font-flow">Nome do cliente</th>
                                <th class="border-2 border-green-600 px-4 py-2 text-white text-left font-flow">CNPJ</th>
                                <th class="border-2 border-green-600 px-4 py-2 text-white text-left font-flow">Telefone</th>
                                <th class="border-2 border-green-600 px-4 py-2 text-white text-left font-flow">Ações</th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse($clientes as $key => $cliente)
                                    <tr>
                                        <td class="border-2 border-emerald-600 px-4 py-2  text-sm font-medium text-emerald-400">{{($key + 1)}}</td>
                                        <td class="border-2 border-emerald-600 px-4 py-2  text-sm font-medium text-emerald-400">{{$cliente->nome}}</td>
                                        <td class="border-2 border-emerald-600 px-4 py-2  text-sm font-medium text-emerald-400">{{$cliente->cnpj}}</td>
                                        <td class="border-2 border-emerald-600 px-4 py-2  text-sm font-medium text-emerald-400">{{$cliente->telefone}}</td>
                                        <td class="border-2 border-emerald-600 px-4 py-2  text-sm font-medium text-emerald-400">
                                            <a href="{{route('clientes.show', $cliente->id)}}" class="text-blue-500" alt="Visualizar">
                                                <svg class="w-8 mr-3 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                  </svg>
                                            </a>

                                            <a href="{{route('clientes.edit', $cliente->id)}}" class="text-green-500" alt="Editar">
                                                <svg  class="w-8 mr-3 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>

                                            <a href="#" class="text-red-500 remover" alt="Deletar" data-id="{{$cliente->id}}">
                                                <svg class="w-8 mr-3 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                  </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="border-2 border-emerald-600 px-4 py-2  text-sm font-medium text-emerald-400">Nenhum cliente cadastrado</td>
                                        </tr>
                                @endforelse
                            </tbody>
                          </table>
                    </div>
                    <div class="flex justify-center">
                        {{ $clientes->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="modal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

          <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>

          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

          <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <!-- Heroicon name: outline/exclamation -->
                  <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                    Excluir cliente
                  </h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500">
                      Ao remover o cliente, todos os orçamentos vinculados a ele serão removidos também. Tem certeza disso?
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form class="form-horizontal" id="theform" method="post" action="{{route('clientes')}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Excluir
                    </button>
                </form>

              <button type="button" id='cancelar' class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancelar
              </button>
            </div>
          </div>
        </div>
      </div>

    <script>
        $(function() {
            var url = "{{route('clientes')}}";
            $("#cancelar").click(function(){
                $("#modal").addClass("hidden");
            });

            $('.remover').click(function(){
                id = $(this).data('id');
                $("#modal").removeClass("hidden");
                console.log(id);
                    s = url+'/'+id;
                    $('#theform').attr('action',s);
            })
        });

    </script>
</x-admin-layout>

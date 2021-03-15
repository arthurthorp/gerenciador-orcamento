<div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium text-gray-900">Informações adicionais</h3>

            <p class="mt-1 text-sm text-gray-600">
                Atualize sua logo e o seu telefone para ser exibido no orçamento
            </p>
        </div>
    </div>

    <div class="mt-5 md:mt-0 md:col-span-2 mb-8">
        <form method="POST" action="{{route("users.logo", Auth::user()->id)}}" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                <div class="grid grid-cols-6 gap-6">
                    @if(Auth::user()->logoUrl())
                        <div class="col-span-6 sm:col-span-2">
                            <img src="{{Auth::user()->logoUrl()}}" alt="Logo">
                        </div>
                    @endif

                    <div class="col-span-6 sm:col-span-4">
                        <label class="block font-medium text-sm text-gray-700" for="logo">
                            Logo
                        </label>
                        <x-input id="logo" name="logo" type="file" class="mt-1 block w-full"  />
                    </div>



                    <div class="col-span-6 sm:col-span-3">
                        <label class="block font-medium text-sm text-gray-700" for="telefone">
                            Telefone
                        </label>
                        <x-input id="telefone" name="telefone" type="text" class="mt-1 block w-full" value="{{Auth::user()->phone}}" required autocomplete="telefone" minlength="15" />
                    </div>
                </div>

            </div>
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <x-button type="submit">
                    Salvar
                </x-button>

            </div>

        </form>
    </div>
</div>

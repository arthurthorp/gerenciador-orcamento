@props(['type'])

@php
    switch ($type) {
        case 'error':
            $classe = "bg-red-400";
            $classe2 = "bg-red-500";
            $icon = '<svg class="text-red-600 w-9 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>';
            break;
        case 'success':
            $classe = "bg-green-400";
            $classe2 = "bg-green-500";
            $icon = '<svg class="text-green-600 w-9 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>';
            break;
        default:
            $classe = "bg-yellow-400";
            $classe2 = "bg-yellow-500";
            $icon = '<svg class="text-yellow-600 w-9 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>';
            break;
    }
@endphp
<div class=" px-8 py-4 rounded-md shadow-lg absolute top-12 text-white right-0 {{$classe}}" style="opacity: 0; transition: opacity .7s linear;" id="toastMessage">
    <span class="flex absolute h-3 w-3 top-0 left-0 -mt-1 -mr-1">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{$classe}} opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 {{$classe2}}"></span>
    </span>
    <div class="flex content-center">
        {!!$icon!!}
        {{$slot}}
    </div>

</div>

<script>
    $(document).ready(function(){

        window.setTimeout(function(){
            $("#toastMessage").css("opacity", 1);
        },200);
        window.setTimeout(function(){

            $("#toastMessage").css("opacity", 0);
            $("#toastMessage").css("display", "none");
        },8000);
    });

</script>

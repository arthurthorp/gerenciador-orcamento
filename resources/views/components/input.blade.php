@props(['disabled' => false])
<input style="outline: 0;" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-green-200 focus:ring duration-200 focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>

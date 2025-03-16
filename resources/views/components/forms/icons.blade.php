{{-- resources/views/components/forms/icons.blade.php --}}
@props([
    "name", // Nombre del ícono (obligatorio)
    "defaultClass" => "w-5 h-5", // Clases por defecto para el contenedor del ícono
    "typeIcon" => "outline", // Tipo de ícono (outline, solid, etc.)
    "error" => true, // Mostrar mensaje de error si el ícono no existe
    "iconClass" => "", // Clases adicionales para el ícono
])

@php
    // Ruta al archivo del ícono
    $iconPath = public_path("images/app/icons/{$typeIcon}/{$name}.blade.php");

    // Verificar si el ícono existe
    $iconExists = file_exists($iconPath);
@endphp

@if ($iconExists)
    {{-- Mostrar el ícono si existe --}}
    <div {{ $attributes->merge(["class" => "{$defaultClass} {$iconClass}"]) }}>
        {!! file_get_contents($iconPath) !!}
    </div>
@else
    {{-- Mostrar mensaje de error si el ícono no existe --}}
    @if ($error)
        <span class="text-red-900 text-pretty font-extralight">
            Icono no encontrado: {{ $name }} (tipo: {{ $typeIcon }})
        </span>
    @endif
@endif


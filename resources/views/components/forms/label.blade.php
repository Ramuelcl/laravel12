{{-- resources/views/components/forms/label.blade.php --}}
@props([
    "for" => "", // ID del input asociado
    "position" => "top", // Posición del label: 'top' o 'left'
    "class" => "", // Clases adicionales
    "required" => false, // Si el label debe mostrar un asterisco
])

@php
  // Estilos base del label
  $baseStyles = "block text-sm font-medium text-gray-700";

  // Estilos adicionales basados en la posición
  $positionStyles = $position === "left" ? "mr-4 min-w-[300px]" : "mb-2";
@endphp

<label
  {{ $attributes->merge([
      "class" => "{$baseStyles} {$positionStyles} {$class}",
      "for" => $for,
  ]) }}>
  {{ $slot }} {{-- Contenido del label --}}
  @if ($required)
    <span class="text-red-500">*</span> {{-- Asterisco para campos obligatorios --}}
  @endif
</label>

{{-- 
  1. Uso independiente:

<x-label for="name" position="top" required>
    Nombre completo
</x-label>
<x-input-text id="name" name="name" placeholder="Ingresa tu nombre" />

2. Uso con posición a la izquierda:

<div class="flex items-center">
    <x-label for="email" position="left" required>
      Correo electrónico
    </x-label>
    <x-input-text id="email" name="email" placeholder="Ingresa tu correo" />
  </div>
----------------------------------------------
  <x-label for="name" position="top" required>
    Nombre completo
 </x-label>
<x-input-text id="name" name="name" placeholder="Ingresa tu nombre" />

--}}

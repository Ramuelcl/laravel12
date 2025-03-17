{{-- resources/views/components/forms/label.blade.php --}}
@props([
    'for' => '', // ID del input asociado
    'position' => 'top', // Posición del label: 'top' o 'left'
    'required' => false, // Si el label debe mostrar un asterisco
    'class' => '', // Clases adicionales
    'labelWidth' => 'w-48', // Ancho estándar para el label (solo aplica cuando position="left")
])

@php
    // Estilos base del label
    $baseStyles = 'block text-sm font-medium text-gray-700';

    // Estilos adicionales basados en la posición
    $positionStyles = $position === 'left' ? "mr-4 {$labelWidth}" : 'mb-2';
@endphp

<label
    {{ $attributes->merge([
        'class' => "{$baseStyles} {$positionStyles} {$class}",
        'for' => $for,
    ]) }}
>
    {{ $slot }} {{-- Contenido del label --}}
    @if ($required)
        <span class="text-red-500">*</span> {{-- Asterisco para campos obligatorios --}}
    @endif
</label>
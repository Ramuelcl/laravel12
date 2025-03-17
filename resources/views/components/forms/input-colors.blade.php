@props([
    'id' => '',
    'name' => '',
    'label' => 'Selecciona un color',
    'labelPosition' => 'top', // Posición del label: 'top' o 'left'
    'labelWidth' => 'w-64', // Ancho del label (por defecto: w-64)
    'labelRequired' => false, // Si el label debe mostrar un asterisco
    'value' => '#000000', // Valor por defecto (color inicial)
    'wireModel' => null, // Para soporte de Livewire (wire:model)
])

@php
    // Convertir el valor hexadecimal a RGB
    function hexToRgb($hex) {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        return "rgb($r, $g, $b)";
    }

    // Obtener el nombre del color (basado en una lista predefinida)
    function getColorName($hex) {
        $colors = [
            '#ff0000' => 'Rojo',
            '#00ff00' => 'Verde',
            '#0000ff' => 'Azul',
            '#ffff00' => 'Amarillo',
            '#ff00ff' => 'Magenta',
            '#00ffff' => 'Cian',
            '#000000' => 'Negro',
            '#ffffff' => 'Blanco',
            // Agrega más colores y nombres aquí
        ];
        return $colors[strtolower($hex)] ?? 'Desconocido';
    }

    $rgbValue = hexToRgb($value);
    $colorName = getColorName($value);
@endphp

<div class="{{ $label ? 'flex items-start' : '' }} {{ $label && $labelPosition === 'left' ? 'flex-row space-x-4' : 'flex-col' }}">
    @if ($label)
        <x-forms.label 
            for="{{ $id }}" 
            position="{{ $labelPosition }}" 
            :required="$labelRequired"
            class="{{ $labelPosition === 'left' ? $labelWidth : 'w-full' }} flex items-center gap-1"
        >
            {{ $label }}
        </x-forms.label>
    @endif

    <div class="relative w-full">
        <input
            type="color"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            wire:model="{{ $wireModel }}"
            class="mt-1 block w-24 h-10 p-1 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />
    </div>

    {{-- Mostrar valores HEX, RGB y nombre del color --}}
    <div class="mt-2 space-y-1">
        <p class="text-sm text-neutral-600"><strong>HEX:</strong> {{ $value }}</p>
        <p class="text-sm text-neutral-600"><strong>RGB:</strong> {{ $rgbValue }}</p>
        <p class="text-sm text-neutral-600"><strong>Nombre:</strong> {{ $colorName }}</p>
    </div>

    <x-forms.input-error :name="$name" />
</div>
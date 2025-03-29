{{-- resources/views/components/forms/on-off.blade.php --}}
@props(['value'=>'0', 'type' => 'On/Off'])

@php
    // Convertir el valor a booleano para simplificar la lógica
    $boolean = (bool) $value;
// dd($boolean,$value);
    // Definir el texto basado en el tipo
    switch ($type) {
        case 'On/Off':
            $text = $boolean ? 'On' : 'Off';
            break;
        case 'si/no':
            $text = $boolean ? 'Sí' : 'No';
            break;
        case 'true/false':
            $text = $boolean ? 'True' : 'False';
            break;
        case '1/0':
            $text = $boolean ? '1' : '0';
            break;
        case 'ticket-x':
            $text = $boolean ? '✓' : '✗';
            break;
        default:
            $text = $boolean ? 'Yes' : 'No';
    }
@endphp

<div>
    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
        {{ $text }}
    </span>
</div>
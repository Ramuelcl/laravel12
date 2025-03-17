{{-- resources/views/components/forms/input-checkbox.blade.php --}}
@props([
    "id" => "",
    "name" => "",
    "multiple" => false, // Permitir múltiples selecciones
    "required" => false,
    "class" => "", // Clases adicionales para el contenedor
    // Label
    "label" => null, // Slot para el label
    "labelPosition" => "top", // Posición del label: 'top' o 'left'
    "labelRequired" => false, // Si el label debe mostrar un asterisco
    "labelWidth" => "w-64", // Ancho del label (por defecto: w-64)
    // Opciones
    "checks" => [], // Arreglo de opciones (clave => valor)
    "checkeds" => [], // Valores seleccionados (puede ser un arreglo si multiple=true)
    // Livewire
    "wireModel" => null, // Para soporte de Livewire (wire:model)
])

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

    <div class="flex flex-col gap-2 {{ $class }}">
        @foreach ($checks as $key => $value)
            <label class="inline-flex items-center">
                <input
                    type="{{ $multiple ? 'checkbox' : 'radio' }}"
                    id="{{ $id }}-{{ $key }}"
                    name="{{ $name }}{{ $multiple ? '[]' : '' }}" 
                    value="{{ $key }}"
                    {{ in_array($key, (array) $checkeds) ? 'checked' : '' }}
                    wire:model="{{ $wireModel }}"
                    class="form-{{ $multiple ? 'checkbox' : 'radio' }} rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
                <span class="ml-2">{{ $value }}</span>
            </label>
        @endforeach
    </div>
    <x-forms.input-error :name="$name" />
</div>
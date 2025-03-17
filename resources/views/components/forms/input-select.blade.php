{{-- resources/views/components/forms/input-select.blade.php --}}
@props([
    "id" => "",
    "name" => "",
    "placeholder" => "Select...",
    "multiple" => false, // Permitir múltiples selecciones
    "required" => false,
    "class" => "w-full", // Ancho del select (por defecto: w-full)
    // Label
    "label" => null, // Slot para el label
    "labelPosition" => "top", // Posición del label: 'top' o 'left'
    "labelRequired" => false, // Si el label debe mostrar un asterisco
    "labelWidth" => "w-64", // Ancho del label (por defecto: w-64)
    // Opciones
    "select" => [], // Arreglo de opciones (clave => valor)
    "selected" => null, // Valor seleccionado (puede ser un arreglo si multiple=true)
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

    <div class="relative w-full">
        <select
            {{ $attributes->merge([
                'class' => "shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {$class}",
                'id' => $id,
                'name' => $name,
                'multiple' => $multiple, // Habilitar múltiples selecciones
                'required' => $required,
                'wire:model' => $wireModel, // Soporte para Livewire
            ]) }}
        >
            @if ($placeholder)
                <option value="" disabled {{ !$selected ? 'selected' : '' }}>
                    {{ $placeholder }}
                </option>
            @endif

            @foreach ($select as $key => $value)
                <option value="{{ $key }}" {{ ($multiple ? in_array($key, (array) $selected) : $selected == $key) ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>
    <x-forms.input-error :name="$name" />
</div>
{{-- resources/views/components/forms/input-text.blade.php --}}
@props([
    "id" => "",
    "name" => "",
    "placeholder" => "",
    "type" => "text", // Tipo de input: 'text', 'password', etc.
    "required" => false,
    "class" => "w-full", // Ancho del input (por defecto: w-full)
    "value" => null,
    // Label
    "label" => null, // Slot para el label
    "labelPosition" => "top", // Posición del label: 'top' o 'left'
    "labelRequired" => false, // Si el label debe mostrar un asterisco
    "labelWidth" => "w-64", // Ancho del label (por defecto: w-64)
    // Ícono
    "icon" => null, // Nombre del ícono
    "iconPosition" => "left", // Posición del ícono: 'left' o 'right'
    "iconClass" => "w-5 h-5", // Clases adicionales para el ícono
    "iconType" => "outline", // Tipo de ícono (outline, solid, etc.)
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
        @if ($icon && $iconPosition === 'left')
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-forms.icons 
                    :name="$icon" 
                    :typeIcon="$iconType" 
                    :defaultClass="$iconClass"
                />
            </div>
        @endif

        <input
            {{ $attributes->merge([
                'class' => "shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {$class} " . ($icon && $iconPosition === 'left' ? 'pl-10' : '') . ($icon && $iconPosition === 'right' ? 'pr-10' : ''),
                'id' => $id,
                'name' => $name,
                'type' => $type, // Tipo de input: 'text', 'password', etc.
                'placeholder' => $placeholder,
                'required' => $required,
                'wire:model' => $wireModel, // Soporte para Livewire
            ]) }}
        >

        @if ($type === 'password')
            {{-- Botón para mostrar/ocultar contraseña --}}
            <button
                type="button"
                class="absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none"
                onclick="togglePasswordVisibility('{{ $id }}')"
            >
                <span id="icon-{{ $id }}">
                    <x-forms.icons :name="'eye'" :class="$iconClass" />
                </span>
            </button>
        @elseif ($icon && $iconPosition === 'right')
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <x-forms.icons 
                    :name="$icon" 
                    :typeIcon="$iconType" 
                    :defaultClass="$iconClass"
                />
            </div>
        @endif
    </div>
    <x-forms.input-error :name="$name" class="block"/>
</div>

{{-- Script para manejar la visibilidad de la contraseña --}}
<script>
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(`icon-${inputId}`);

        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<x-forms.icons name="eye-off" class="{{ $iconClass }}" />`; // Cambiar a ícono "eye-off"
        } else {
            input.type = 'password';
            icon.innerHTML = `<x-forms.icons name="eye" class="{{ $iconClass }}" />`; // Cambiar a ícono "eye"
        }
    }
</script>
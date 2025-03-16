{{-- resources/views/components/forms/input-password.blade.php --}}
@props([
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'required' => false,
    'class' => '',
    'label' => null, // Slot para el label
    'labelPosition' => 'top', // Posición del label
    'labelRequired' => false, // Si el label debe mostrar un asterisco
    'iconShow' => 'eye', // Ícono para mostrar contraseña
    'iconHide' => 'eye-off', // Ícono para ocultar contraseña
    'iconClass' => 'w-5 h-5', // Clases adicionales para el ícono
])

<div>
    @if ($label)
        <x-label 
            for="{{ $id }}" 
            position="{{ $labelPosition }}" 
            :required="$labelRequired"
        >
            {{ $label }}
        </x-label>
    @endif

    <div class="relative">
        {{-- Botón para mostrar/ocultar contraseña --}}
        <button
            type="button"
            class="absolute inset-y-0 left-0 pl-3 flex items-center focus:outline-none"
            onclick="togglePasswordVisibility('{{ $id }}')"
        >
            <span id="icon-{{ $id }}">
                <x-forms.icons :name="$iconShow" :class="$iconClass" />
            </span>
        </button>

        {{-- Input de contraseña --}}
        <input
            {{ $attributes->merge([
                'class' => "shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {$class} pl-10",
                'id' => $id,
                'name' => $name,
                'type' => 'password', // Tipo inicial es "password"
                'placeholder' => $placeholder,
                'required' => $required,
            ]) }}
        >
    </div>
</div>

{{-- Script para manejar la visibilidad de la contraseña --}}
<script>
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(`icon-${inputId}`);

        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<x-forms.icons name="{{ $iconHide }}" class="{{ $iconClass }}" />`; // Cambiar a ícono "eye-off"
        } else {
            input.type = 'password';
            icon.innerHTML = `<x-forms.icons name="{{ $iconShow }}" class="{{ $iconClass }}" />`; // Cambiar a ícono "eye"
        }
    }
</script>
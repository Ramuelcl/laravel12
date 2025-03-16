{{-- resources/views/components/input-text.blade.php --}}
@props([
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'required' => false,
    'class' => '',
    'label' => null, // Slot para el label
    'labelPosition' => 'top', // Posición del label
    'labelRequired' => false, // Si el label debe mostrar un asterisco
    'icon' => null, // Nombre del ícono
    'iconPosition' => 'left', // Posición del ícono: 'left' o 'right'
    'iconClass' => 'w-5 h-5', // Clases adicionales para el ícono
    'iconType' => 'outline', // Tipo de ícono (outline, solid, etc.)
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
                'type' => 'text',
                'placeholder' => $placeholder,
                'required' => $required,
            ]) }}
        >

        @if ($icon && $iconPosition === 'right')
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <x-forms.icons 
                    :name="$icon" 
                    :typeIcon="$iconType" 
                    :defaultClass="$iconClass"
                />
            </div>
        @endif
    </div>
</div>
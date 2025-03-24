{{-- resource/views/components/forms/input-file.blade.php --}}
@props([
    'id' => '',
    'name' => '',
    'label' => 'Selecciona un archivo',
    'labelPosition' => 'top', // Posición del label: 'top' o 'left'
    'labelWidth' => 'w-64', // Ancho del label (por defecto: w-64)
    'labelRequired' => false, // Si el label debe mostrar un asterisco
    'value' => null, // Archivo actual (para edición)
    'wireModel' => null, // Para soporte de Livewire (wire:model)
    'accept' => '*', // Tipos de archivo aceptados (por defecto: todos)
])

@php
    // Obtener detalles del archivo
    $fileName = '';
    $fileSize = 0;
    $filePath = '';
    $fileType = '';

    if ($value) {
        $fileName = $value->getClientOriginalName();
        $fileSize = $value->getSize();
        $filePath = $value->getPathname();
        $fileType = $value->getMimeType();
    }

    // Convertir el tamaño del archivo a KB, MB o GB
    function formatFileSize($bytes) {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    $formattedSize = $fileSize ? formatFileSize($fileSize) : '';

    // Extraer wire:model de los atributos
    $wire = $attributes->wire('model');
    $attributes = $attributes->except('wire:model'); // Eliminar wire:model de los atributos
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
            type="file"
            id="{{ $id }}"
            name="{{ $name }}"
            {{ $wire }} {{-- Aplicar wire:model aquí --}}
            {{ $attributes->class(['mt-1 block w-full p-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500']) }}
            accept="{{ $accept }}"
        />
    </div>

    {{-- Mostrar detalles del archivo --}}
    @if ($value)
        <div class="mt-4">
            <p class="text-sm text-neutral-600"><strong>Nombre:</strong> {{ $fileName }}</p>
            <p class="text-sm text-neutral-600"><strong>Tamaño:</strong> {{ $formattedSize }}</p>
            <p class="text-sm text-neutral-600"><strong>Tipo:</strong> {{ $fileType }}</p>

            {{-- Vista previa del archivo --}}
            @if (str_starts_with($fileType, 'image/'))
                <div class="mt-2">
                    <img src="{{ $value->temporaryUrl() }}" alt="Vista previa" class="max-w-full h-auto rounded-md">
                </div>
            @else
                <div class="mt-2 p-2 bg-neutral-100 rounded-md">
                    <p class="text-sm text-neutral-600">No hay vista previa disponible para este tipo de archivo.</p>
                </div>
            @endif
        </div>
    @endif

    <x-forms.input-error :name="$name" />
</div>
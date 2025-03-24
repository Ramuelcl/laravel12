<?php
// resources/views/livewire/forms/inputfile.blade.php

use function Livewire\Volt\{state, computed};

// Estado del componente
state(['file' => null]);

// Propiedades computadas para detalles del archivo
computed('fileName', fn () => $this->file ? $this->file->getClientOriginalName() : null);
computed('fileSize', fn () => $this->file ? formatFileSize($this->file->getSize()) : null);
computed('fileType', fn () => $this->file ? $this->file->getMimeType() : null);
computed('isImage', fn () => $this->file ? str_starts_with($this->file->getMimeType(), 'image/') : false);

// Función auxiliar para formatear el tamaño del archivo
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

// Manejador para cuando se selecciona un archivo
$setFile = function ($event) {
    $this->file = $event->target->files[0] ?? null;
};
?>

<div class="space-y-4">
    <!-- Campo de selección de archivo -->
    <div>
        <label for="file" class="block text-sm font-medium text-gray-700">Selecciona un archivo</label>
        <input
            type="file"
            id="file"
            wire:model="file"
            wire:change="$setFile"
            class="mt-1 block w-full p-2 border border-neutral-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        />
    </div>

    <!-- Mostrar detalles del archivo seleccionado -->
    @if ($file)
        <div class="mt-4 space-y-2">
            <p class="text-sm text-gray-600"><strong>Nombre:</strong> {{ $fileName }}</p>
            <p class="text-sm text-gray-600"><strong>Tamaño:</strong> {{ $fileSize }}</p>
            <p class="text-sm text-gray-600"><strong>Tipo:</strong> {{ $fileType }}</p>

            <!-- Vista previa del archivo -->
            @if ($isImage)
                <div class="mt-2">
                    <img src="{{ $file->temporaryUrl() }}" alt="Vista previa" class="max-w-full h-auto rounded-md">
                </div>
            @else
                <div class="mt-2 p-2 bg-gray-100 rounded-md">
                    <p class="text-sm text-gray-600">No hay vista previa disponible para este tipo de archivo.</p>
                </div>
            @endif
        </div>
    @endif
</div>
{{-- resources/views/components/forms/tw_window.blade.php --}}
@props([
'width' => 'w-96', // Ancho por defecto
'title' => 'Title of window',
'position' => 'absolute top-10 left-10' // Posición por defecto
])

{{-- Contenedor no modal con posición personalizada --}}
<div class="{{ $position }} {{ $width }} border border-gray-300 rounded-md shadow-lg bg-white dark:bg-gray-800 z-20"
  id="ventana">
  <div class="bg-blue-500 px-4 py-2 rounded-t-md flex items-center justify-between">
    <span class="text-white font-semibold text-lg">{{ __($title) }}</span>
  </div>

  <div class="p-4">
    <!-- Contenido principal -->
    {{ $slot }}
  </div>

  @isset($footer)
  {{-- Pie de página para botones de acción --}}
  <div class="bg-gray-100 px-4 py-2 rounded-b-md border-t-2 flex justify-end space-x-2">
    {{ $footer }}
  </div>
  @endisset
</div>
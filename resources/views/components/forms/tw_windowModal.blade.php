{{-- resources/views/components/forms/tw_windowModal.blade.php --}}
@props([
'width' => 'w-98', // Ancho por defecto
'title' => 'Title of window'
])

<div class="fixed inset-0 flex items-center justify-center z-50" style="display: block;">
  {{-- Fondo oscuro semitransparente --}}
  <div class="fixed inset-0 bg-black opacity-50" wire:click="toggleWindowModal"></div>

  {{-- Ventana modal centrada --}}
  <div class="border border-gray-300 rounded-md shadow-lg bg-white dark:bg-gray-800 {{ $width }} relative z-10">
    <div class="bg-blue-500 px-4 py-2 rounded-t-md flex items-center justify-between">
      <span class="text-white font-semibold text-lg">{{ __($title) }}</span>
      <div class="ml-auto space-x-2">
        {{-- Ícono de cerrar --}}
        <x-forms.tw_icons wire:click="toggleWindowModal" name="x" class="text-gray-50 cursor-pointer" />
      </div>
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
</div>
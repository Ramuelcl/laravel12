{{-- resources/views/components/forms/tw_window.blade.php --}}
@props([
'width' => 'w-96',
'title' => 'Title of window',
'modal' => false,
'containerId' => 'container' // ID del contenedor base
])

<div class="{{ $modal ? 'fixed inset-0' : 'absolute top-10 left-10' }} flex items-center justify-center z-50"
  id="modalContainer" style="display: none;">
  @if ($modal)
  <div class="fixed inset-0 bg-black opacity-50" id="overlay"></div>
  @endif

  <div class="border border-gray-300 rounded-md shadow-lg bg-white dark:bg-gray-800 {{ $width }} relative z-10"
    id="ventana">
    <div class="bg-blue-500 px-4 py-2 rounded-t-md flex items-center justify-between">
      <span class="text-white font-semibold text-lg">{{ __($title) }}</span>
      @if ($modal)
      <div class="ml-auto space-x-2">
        <x-forms.tw_icons id="cerrarBtn" name="x" class="text-gray-50 cursor-pointer" />
      </div>
      @endif
    </div>

    <div class="p-4">
      <!-- Contenido principal (Formulario) -->
      {{ $slot }}
    </div>

    @isset($footer)
    {{-- Pie de página para los botones del formulario --}}
    <div class="bg-gray-100 px-4 py-2 rounded-b-md border-t-2 flex justify-end space-x-2">
      {{ $footer }}
    </div>
    @endisset
  </div>
</div>

<script>
  const modalContainer = document.getElementById('modalContainer');
  const overlay = document.getElementById('overlay');
  const cerrarBtn = document.getElementById('cerrarBtn');
  // const containerId = @json($containerId);

  function abrirModal(isModal = true) {
    modalContainer.style.display = 'flex';
    const container = document.getElementById(containerId);
    if (container) container.appendChild(modalContainer);

    if (isModal && overlay) {
      overlay.style.display = 'block';
      overlay.addEventListener('click', cerrarModal);
    } else {
      if (overlay) overlay.style.display = 'none';
      overlay?.removeEventListener('click', cerrarModal);
    }
  }

  function cerrarModal() {
    modalContainer.style.display = 'none';
  }

  if (cerrarBtn) cerrarBtn.addEventListener('click', cerrarModal);
</script>
<!-- resources/views/components/authentication-card-logo.blade.php -->
@props(['size' => 'mini', 'url' => '#', 'title' => true])

@php
  // Validar y establecer el tamaño
  $size = in_array($size, ['mini', 'med', 'large']) ? $size : 'mini';

  // Establecer el tamaño predeterminado según el valor de $size
  $defaultSize = match ($size) {
      'mini' => 50,
      'med' => 100,
      'large' => 200,
  };

  // Establecer la URL predeterminada si no se proporciona una
  $url = $url === '#' ? url('/') : $url;

  // Obtener la ruta de la imagen desde la configuración o usar una predeterminada
  $img = config('guzanet.appLogo', 'images/guzanet.png');
@endphp

<a href="{{ $url }}">
  <div class="flex items-center justify-center font-bold text-2xl text-blue-900">
    <img src="{{ asset($img) }}" alt="Logo" style="width: {{ $defaultSize }}px; height: {{ $defaultSize }}px;">
    @if ($title)
      <span class="ml-2">{{ config('guzanet.appEmpresa', 'falta nombre empresa') }}</span>
    @endif
  </div>
</a>

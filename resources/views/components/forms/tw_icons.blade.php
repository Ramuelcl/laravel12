{{-- resources\views\components\tw_icons.blade.php --}}
@props(["name", "defaultClass" => "w-5 h-5", "typeIcon" => "outline", 'error'=>true])

@php
$iconPath = public_path("app/icons/{$typeIcon}/{$name}.blade.php");
@endphp

@if (file_exists($iconPath))
{{-- Leer y mostrar el contenido del icono --}}
<div {{ $attributes->merge(["class" => $defaultClass]) }}>
  {!! file_get_contents($iconPath) !!}
</div>
@else
@if($error)
{{-- Si el icono no se encuentra, mostrar un mensaje --}}
<span class="text-red-900 text-pretty font-extralight">Icono no está: {{ $name }}</span>
@endif
@endif
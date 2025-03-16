{{-- resources/views/partials/camposTable.blade.php --}}
@foreach ($table as $campoNombre => $campoInfo)
@php
// Obtén el valor del campo actual
$valorCampo = $data->$campoNombre;
// Obtén el tipo de campo desde el arreglo $table
$tipoCampo = $campoInfo["type"] ?? null;
// Verifica si el campo es visible en la tabla
$visible = $campoInfo["visible"] ?? false;
@endphp

@if ($visible)
<td class="border-none px-4 py-1 text-gray-900 dark:text-white">
  @switch($tipoCampo)
  @case("integer")
  @case("decimal")
  <div class="text-right">
    {{ number_format($valorCampo, $campoInfo["decimal"] ?? 2, ".", ",") }}
  </div>
  @break

  @case("date")
  <div class="text-center">
    {{ date("d/m/Y", strtotime($valorCampo)) }}
  </div>
  @break

  @case("boolean")
  <div class="text-center">
    <livewire:on-off :valor="$valorCampo" formato="yes/no" />
  </div>
  @break

  @case("checkit")
  <div class="text-center">
    <livewire:on-off :valor="$valorCampo" formato="ticket-x" />
  </div>
  @break

  @case("tags")
  <div class="text-center">
    @if ($data->tags->isEmpty())
    No tags
    @else
    @foreach ($data->tags as $tag)
    <span>{{ $tag->name }}</span>
    @if (!$loop->last)
    -
    @endif
    @endforeach
    @endif
  </div>
  @break

  @case("select")
  <div class="text-left">
    @php
    // Encuentra el registro cuyo ID coincide con $valorCampo utilizando el modelo genérico
    $relatedData = $data1::find($valorCampo);
    @endphp
    {{ $relatedData ? $relatedData->name : "no encontrada" }}
  </div>
  @break

  @case("image")
  <div class="h-10 w-10 text-center">
    @if (!is_null($valorCampo) && Storage::disk("public")->exists($valorCampo))
    <img alt="Foto" src="{{ asset("storage/" . $valorCampo) }}">
    @endif
  </div>
  @break

  @default
  <div class="text-left">
    {{ $valorCampo }}
  </div>
  @endswitch
</td>
@endif
@endforeach
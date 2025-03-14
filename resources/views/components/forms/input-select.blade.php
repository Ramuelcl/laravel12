{{-- resources/views/components/forms/input-select.blade.php --}}
@props([
    "disabled" => false,
    "label" => null,
    "id" => "",
    "name" => "",
    "value" => null,
    "class" => "",
    "options" => [], // Opciones para el select
    "labelPosition" => "left", // Posición del label: left, up, right, down
    "labelWidth" => "w-1/3", // Ancho máximo del label (predeterminado)
    "inputWidth" => "w-full", // Ancho máximo del input (predeterminado)
])

@php
  $classFix =
      "font-normal text-blue-500 dark:text-blue-100 block rounded-md form-input border-blue-400 focus:border-blue-600 mb-3";
  $position = "grid grid-cols-12 gap-4 items-center";
  $l = "sm:col-span-3 text-left " . $labelWidth;

  if ($labelPosition === "up") {
      $position = "flex flex-col space-y-1";
      $l = "block mb-1 w-full";
  } elseif ($labelPosition === "down") {
      $position = "flex flex-col-reverse space-y-1";
      $l = "block mt-1 w-full";
  } elseif ($labelPosition === "right") {
      $l = "sm:col-span-3 text-right " . $labelWidth;
  }
@endphp

{{-- Contenedor flexible para el label y el select --}}
<div class="{{ $position }} w-full">
  {{-- Etiqueta --}}
  @if ($label)
    <label for="{{ $id ?? $name }}"
      class="text-sm text-gray-700 dark:text-gray-200 {{ $l }} whitespace-nowrap">
      {{ $label }}
    </label>
  @endif

  {{-- Select --}}
  <div class="@if ($labelPosition !== "up") sm:col-span-9 w-full @endif">
    <select id="{{ $id ?? $name }}" name="{{ $name }}" {{ $disabled ? "disabled" : "" }} {!! $attributes->merge(["class" => "$classFix $class w-full"]) !!}>
      <option value="" disabled>Seleccione</option>
      @foreach ($options as $key => $option)
        <option value="{{ $key }}" {{ $value == $key ? "selected" : "" }}>{{ $option }}</option>
      @endforeach
    </select>
  </div>
</div>

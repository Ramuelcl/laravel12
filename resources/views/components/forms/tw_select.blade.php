{{-- resources/views/components/forms/tw_select.blade.php --}}
@props([
    'disabled' => false,
    'label' => null,
    'id' => '',
    'name' => '',
    'value' => null,
    'class' => '',
    'options' => [], // Para el tipo select
    'multiple' => false, // Para el tipo select
    'placeholder' => null, // Para el tipo select
    // Agrega más propiedades según sea necesario
])
{{-- Contenedor flexible para el label y el input --}}
<div class="flex w-full">
  @if ($label)
    <label for="{{ $id ?? $name }}" class="text-sm text-gray-700 dark:text-gray-200 mr-6">
      {{ $label }}
    </label>
  @endif

  <select id="{{ $id ?? $name }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
      'class' => "font-normal text-blue-500 dark:text-blue-100 block rounded-md form-input border-blue-400
              focus:border-blue-600 mb-3 $class max-w-full",
  ]) !!}>
    <option value="" disabled>{{ __($placeholder ?? 'Select') }}</option>
    @foreach ($options as $key => $option)
      <option value="{{ $key }}" {{ $value == $key ? 'selected' : '' }}>{{ $option }}</option>
    @endforeach
  </select>
</div>

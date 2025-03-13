{{-- resources/views/components/forms/tw_input.blade.php --}}
@props([
'disabled' => false,
'type' => 'text',
'label' => null,
'id' => '',
'name' => '',
'value' => null,
'class' => 'font-normal text-blue-500 dark:text-blue-100 block mt-1 w-full rounded-md form-input border-blue-400
focus:border-blue-600 mb-3',
'options' => [], // Para el tipo select
])

@if ($label && $type != 'checkbox' && $type != 'select')
<x-forms.tw_label class="ml-2" for="{{ $id ?? $name }}">{{ $label }}</x-forms.tw_label>
@endif

@if ($type == 'textarea')
<textarea id="{{ $id ?? $name }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!!
  $attributes->merge(['class' => $class]) !!}>{{ $value }}</textarea>

@elseif ($type == 'checkbox')
<div class="flex items-center">
  <input id="{{ $id ?? $name }}" name="{{ $name }}" type="checkbox" value="{{ $value }}" {{ $disabled ? 'disabled' : ''
    }} {!! $attributes->merge(['class' => 'form-checkbox h-4 w-4 rounded-full text-blue-600']) !!} />
  @if ($label)
  <label class="ml-2 text-sm text-blue-600 dark:text-blue-100" for="{{ $id ?? $name }}">{{ $label }}</label>
  @endif
</div>

@elseif ($type == 'select')
@if ($label)
<x-forms.tw_label class="ml-2" for="{{ $id ?? $name }}">{{ $label }}</x-forms.tw_label>
@endif
<select id="{{ $id ?? $name }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' =>
  $class]) !!}>
  <option value="" disabled>Seleccione</option>
  @foreach ($options as $key => $option)
  <option value="{{ $key }}" {{ $value==$key ? 'selected' : '' }}>{{ $option }}</option>
  @endforeach
</select>

@elseif ($type == 'password')
<div class="relative">
  <input id="{{ $id ?? $name }}" name="{{ $name }}" type="password" value="{{ $value }}" {{ $disabled ? 'disabled' : ''
    }} {!! $attributes->merge(['class' => $class]) !!} />
  <button type="button" onclick="togglePasswordVisibility('{{ $id ?? $name }}')"
    class="absolute inset-y-0 right-0 px-3 text-gray-500 focus:outline-none">
    <x-forms.tw_icons id="icon-{{ $id ?? $name }}" name="eye" />
  </button>
</div>

@else
<input id="{{ $id ?? $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}" {{ $disabled ? 'disabled' : ''
  }} {!! $attributes->merge(['class' => $class]) !!} />
<x-input-error :messages="$errors->get( $name ?? $id)" class="mt-2" />
@endif

{{-- Script para mostrar/ocultar la contraseña --}}
<script>
  function togglePasswordVisibility(inputId) {
        const inputField = document.getElementById(inputId);
        const icon = document.getElementById('icon-' + inputId);

        if (inputField.type === 'password') {
            inputField.type = 'text';
            icon.classList.add('text-blue-600');
        } else {
            inputField.type = 'password';
            icon.classList.remove('text-blue-600');
        }
    }
</script>
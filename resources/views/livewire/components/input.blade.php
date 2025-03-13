<?php // resources/views/livewire/components/input.blade.php

use Livewire\Volt\Component;

new class extends Component {
    // Propiedades públicas
    public $disabled = false;
    public $type = "text";
    public $label = null;
    public $id = "";
    public $name = "";
    public $value = null;
    public $class = "font-normal text-blue-500 dark:text-blue-100 block mt-1 w-full rounded-md form-input border-blue-400 focus:border-blue-600 mb-3";
    public $options = []; // Para el tipo select
    public $showPassword = false; // Para el tipo password

    // Método para alternar la visibilidad de la contraseña
    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }
};
?>

<div>
  @if ($label && $type != "checkbox" && $type != "select")
    <x-forms.tw_label class="ml-2" for="{{ $id ?? $name }}">{{ $label }}</x-forms.tw_label>
  @endif

  @if ($type == "textarea")
    <textarea id="{{ $id ?? $name }}" name="{{ $name }}" wire:model="value" {{ $disabled ? "disabled" : "" }}
      {!! $attributes->merge(["class" => $class]) !!}>{{ $value }}</textarea>
  @elseif ($type == "checkbox")
    <div class="flex items-center">
      <input id="{{ $id ?? $name }}" name="{{ $name }}" type="checkbox" wire:model="value"
        {{ $disabled ? "disabled" : "" }} {!! $attributes->merge(["class" => "form-checkbox h-4 w-4 rounded-full text-blue-600"]) !!} />
      @if ($label)
        <label class="ml-2 text-sm text-blue-600 dark:text-blue-100"
          for="{{ $id ?? $name }}">{{ $label }}</label>
      @endif
    </div>
  @elseif ($type == "select")
    @if ($label)
      <x-forms.tw_label class="ml-2" for="{{ $id ?? $name }}">{{ $label }}</x-forms.tw_label>
    @endif
    <select id="{{ $id ?? $name }}" name="{{ $name }}" wire:model="value" {{ $disabled ? "disabled" : "" }}
      {!! $attributes->merge(["class" => $class]) !!}>
      <option value="" disabled>Seleccione</option>
      @foreach ($options as $key => $option)
        <option value="{{ $key }}" {{ $value == $key ? "selected" : "" }}>{{ $option }}</option>
      @endforeach
    </select>
  @elseif ($type == "password")
    <div class="relative">
      <input id="{{ $id ?? $name }}" name="{{ $name }}" type="{{ $showPassword ? "text" : "password" }}"
        wire:model="value" {{ $disabled ? "disabled" : "" }} {!! $attributes->merge(["class" => $class]) !!} />
      <button type="button" wire:click="togglePasswordVisibility"
        class="absolute inset-y-0 right-0 px-3 text-gray-500 focus:outline-none">
        <x-forms.tw_icons id="icon-{{ $id ?? $name }}" name="{{ $showPassword ? "eye-off" : "eye" }}" />
      </button>
    </div>
  @else
    <input id="{{ $id ?? $name }}" name="{{ $name }}" type="{{ $type }}" wire:model="value"
      {{ $disabled ? "disabled" : "" }} {!! $attributes->merge(["class" => $class]) !!} />
    <x-input-error :messages="$errors->get($name ?? $id)" class="mt-2" />
  @endif
</div>

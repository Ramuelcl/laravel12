<?php // resources/views/livewire/components/input-select.blade.php

use Livewire\Volt\Component;

new class extends Component {
    // Propiedades públicas
    public $options = []; // Arreglo de opciones disponibles
    public $selected = []; // Arreglo de opciones seleccionadas
    public $placeholder = "Select(s)"; // Placeholder del select
    public $multiple = false; // Si permite selección múltiple
    public $disabled = true; // Si el select está habilitado
    public $hidden = false; // Si el select está oculto

    // Método para emitir las opciones seleccionadas
    public function updatedSelected($value)
    {
        $this->dispatch("selected-updated", selected: $this->selected);
    }
};
?>

<div @class(["hidden" => $hidden])>
  <select wire:model="selected" id="input-select" @class([
      "mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500",
      "opacity-50 cursor-not-allowed" => !$disabled,
  ])
    @if ($multiple) multiple @endif @if (!$disabled) disabled @endif>
    <option value="" disabled>{{ $placeholder }}</option>

    @foreach ($options as $value => $label)
      <option value="{{ $value }}" @if (in_array($value, $selected)) selected @endif>
        {{ $label }}
      </option>
    @endforeach
  </select>
</div>

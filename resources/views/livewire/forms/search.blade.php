<?php

use Livewire\Attributes\Dispatch;
use Livewire\Volt\Component;

new class extends Component {
    public string $search = '';
    public string $placeholder = 'Buscar...';
    public bool $disabled = false;

    public function mount(string $placeholder = 'Buscar...', bool $disabled = false): void
    {
        $this->placeholder = $placeholder;
        $this->disabled = $disabled;
    }

    #[Dispatch('search-triggered')]
    public function searchTriggered(): string
    {
        return $this->search;
    }
}; ?>

<div class="relative">
  <div
    class="flex items-center overflow-hidden rounded-lg border border-gray-300 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 bg-white transition-all duration-200 ease-in-out shadow-sm hover:shadow">
    <div class="flex items-center justify-center pl-3">
      <x-forms.icons name="search" class="w-5 h-5 text-gray-400" />
    </div>
    <input type="search" wire:model.live.debounce.300ms="search" wire:keydown.enter="searchTriggered"
      class="block w-full py-2 pl-2 pr-3 text-sm text-gray-700 border-0 focus:ring-0 focus:outline-none"
      placeholder="{{ __($this->placeholder) }}" @if ($disabled) disabled @endif />
  </div>
</div>

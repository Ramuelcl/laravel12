{{-- resources/views/datatable.blade.php --}}
<x-layouts.app title="DataTable">
  <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="relative h-full p-4 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

      @livewire("forms.datatable")

    </div>
  </div>
</x-layouts.app>

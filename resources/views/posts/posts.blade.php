{{-- resources/views/posts/posts.blade.php --}}
<x-layouts.app title="Posts">
  <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="relative h-full p-4 flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
      <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __("Posts") }}</flux:heading>
        {{-- <flux:subheading size="lg" class="mb-6">{{ __("Crud") }}</flux:subheading> --}}
        <flux:separator variant="subtle" />
      </div>
      @livewire("posts.posts")

    </div>
  </div>
</x-layouts.app>

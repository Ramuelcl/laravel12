{{-- resources/views/components/forms/tw_mensajes.blade.php
uso: session()->flash('success', 'Operación realizada con éxito.');
--}}
{{-- SUCCESS --}}
@if (Session::has('success'))
<div class="m-2 mb-4 inline-flex w-full overflow-hidden rounded-lg border-2 border-green-700 bg-success shadow-md">
  <div class="flex w-12 items-center justify-center border-r-4">
    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-blue-700 border-black border-2">
      <svg class="h-6 w-6 fill-current text-green-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
        fill="currentColor">
        <path fill-rule="evenodd"
          d="M9.293 16.293a1 1 0 0 1-1.414 0l-5-5a1 1 0 1 1 1.414-1.414L9 13.586l9.293-9.293a1 1 0 1 1 1.414 1.414l-10 10z"
          clip-rule="evenodd" />
      </svg>
    </div>
  </div>

  <div class="-mx-3 px-4 py-2">
    <div class="mx-3">
      <span class="font-semibold text-green-100">{{ __('Success') }}</span>
      <p class="text-sm text-green-200">{{ Session::get('success') }}</p>
    </div>
  </div>
</div>
@endif

{{-- INFO --}}
@if (Session::has('info'))
<div class="m-2 mb-4 inline-flex w-full overflow-hidden rounded-lg border-2 border-blue-700 bg-info shadow-md">
  <div class="flex w-12 items-center justify-center border-r-4">
    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-blue-700 border-black border-2">
      i
    </div>
  </div>

  <div class="-mx-3 px-4 py-2">
    <div class="mx-3">
      <span class="font-semibold text-blue-100">{{ __('Info')}}</span>
      <p class="text-sm text-blue-200">{{ Session::get('info') }}</p>
    </div>
  </div>
</div>
@endif

@if (Session::has('danger'))
{{-- Error --}}
<div class="m-2 mb-4 inline-flex w-full overflow-hidden rounded-lg border-2 border-red-700 bg-danger shadow-md">
  <div class="flex w-12 items-center justify-center border-r-4">
    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-red-700 border-black border-2">
      X
    </div>
  </div>

  <div class="-mx-3 px-4 py-2">
    <div class="mx-3">
      <span class="font-semibold text-red-100">{{ __('Danger')}}</span>
      <p class="text-sm text-red-200">{{ Session::get('danger') }}</p>
    </div>
  </div>
</div>
@endif

{{-- warning --}}
@if (Session::has('warning'))
<div class="m-2 mb-4 inline-flex w-full rounded-lg border-2 border-yellow-700 bg-warning shadow-md">
  <div class="flex w-12 items-center justify-center border-r-4">
    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-red-700 border-black border-2">
      !
    </div>
  </div>
  <div class="-mx-3 px-4 py-2">
    <div class="mx-3">
      <span class="font-semibold text-yellow-400">{{ __('Warning')}}</span>
      <p class="text-sm text-yellow-500">{{ Session::get('warning') }}</p>
    </div>
  </div>
</div>
@endif
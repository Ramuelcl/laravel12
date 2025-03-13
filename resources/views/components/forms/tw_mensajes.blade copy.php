{{-- resources/views/components/forms/tw_mensajes.blade.php 
  uso: <x-forms.tw_mensajes />
  llamada
  --}}
@if (Session::has('success') || Session::has('info') || Session::has('danger') || Session::has('warning'))
<div class="m-2 mb-4 inline-flex w-full overflow-hidden rounded-lg shadow-md"
  :class="{
      'border-2 border-green-700 bg-success': Session::has('success'),
      'border-2 border-blue-700 bg-info': Session::has('info'),
      'border-2 border-red-700 bg-danger': Session::has('danger'),
      'border-2 border-yellow-700 bg-warning': Session::has('warning'),
    }">
  <div class="flex w-12 items-center justify-center border-r-4">
    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white"
      :class="{
          'text-green-800': Session::has('success'),
          'text-blue-700': Session::has('info'),
          'text-red-700': Session::has('danger'),
          'text-red-700': Session::has('warning'),
        }">
      @if (Session::has('success'))
      <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
        fill="currentColor">
        <path fill-rule="evenodd"
          d="M9.293 16.293a1 1 0 0 1-1.414 0l-5-5a1 1 0 1 1 1.414-1.414L9 13.586l9.293-9.293a1 1 0 1 1 1.414 1.414l-10 10z"
          clip-rule="evenodd" />
      </svg>
      @elseif (Session::has('info'))
      i
      @elseif (Session::has('warning'))
      !
      @elseif (Session::has('danger'))
      X
      @endif
    </div>
  </div>

  <div class="-mx-3 px-4 py-2">
    <div class="mx-3">
      @if (Session::has('success'))
      <span class="font-semibold text-green-100">{{ __('Success') }}</span>
      <p class="text-sm text-green-200">{{ Session::get('success') }}</p>
      @elseif (Session::has('info'))
      <span class="font-semibold text-blue-100">{{ __('Info') }}</span>
      <p class="text-sm text-blue-200">{{ Session::get('info') }}</p>
      @elseif (Session::has('danger'))
      <span class="font-semibold text-red-100">{{ __('Danger') }}</span>
      <p class="text-sm text-red-200">{{ Session::get('danger') }}</p>
      @elseif (Session::has('warning'))
      <span class="font-semibold text-yellow-400">{{ __('Warning') }}</span>
      <p class="text-sm text-yellow-500">{{ Session::get('warning') }}</p>
      @endif
    </div>
  </div>
</div>
@endif
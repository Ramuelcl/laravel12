{{-- resources/views/components/forms/input-error.blade.php --}}
@props(["name" => null])

@error($name)
  <div class="flex items-center text-red-500 text-sm mt-1">
    <x-forms.icons name="exclamation-circle" class="w-4 h-4 mr-1" /> <!-- Ícono de error -->
    <span>{{ $message }}</span>
  </div>
@enderror

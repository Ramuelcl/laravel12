{{-- resources/views/components/forms/tw_label.blade.php --}}

@props(['id' => '', 'name' => '', 'class' => ''])

<label for="{{ $id ?? $name }}" {{ $attributes->merge(['class' => 'block text-sm font-medium leading-6 text-lightText
  dark:text-darkText
  rounded-md' . $class]) }} >
  {{ $slot }}
</label>
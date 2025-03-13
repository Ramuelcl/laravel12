@props(['name'=>null])
@error($name)
<p class="mt-1 text-sm text-red-600 dark:text-red-400 space-y-1">{{ $message }}</p>
@enderror
{{-- resources\views\components\tw_button.blade.php --}}

@props([
"name" => "button",
"type" => "submit",
"color" => "blue",
"class" => "",
"classFix" => "inline-flex items-center justify-center px-4 py-2 font-semibold text-sm rounded-md transition ease-in-out
duration-150 focus:outline-none focus:ring",
])

@php
$colors = [
"blue" => "bg-blue-600 dark:bg-blue-400 text-blue-100 dark:text-blue-800 hover:bg-blue-400 dark:hover:bg-blue-200
active:bg-blue-400 dark:active:bg-blue-200 focus:ring-blue-700 dark:focus:ring-blue-500 disabled:bg-blue-300
dark:disabled:bg-blue-200 disabled:cursor-not-allowed",
"red" => "bg-red-600 dark:bg-red-400 text-red-100 dark:text-red-800 hover:bg-red-400 dark:hover:bg-red-200
active:bg-red-400 dark:active:bg-red-200 focus:ring-red-700 dark:focus:ring-red-500 disabled:bg-red-300
dark:disabled:bg-red-200 disabled:cursor-not-allowed",
"gray" => "bg-gray-600 dark:bg-gray-400 text-gray-100 dark:text-gray-800 hover:bg-gray-400 dark:hover:bg-gray-200
active:bg-gray-400 dark:active:bg-gray-200 focus:ring-gray-700 dark:focus:ring-gray-500 disabled:bg-gray-300
dark:disabled:bg-gray-200 disabled:cursor-not-allowed",
"green" => "bg-green-600 dark:bg-green-400 text-green-100 dark:text-green-800 hover:bg-green-400 dark:hover:bg-green-200
active:bg-green-400 dark:active:bg-green-200 focus:ring-green-700 dark:focus:ring-green-500 disabled:bg-green-300
dark:disabled:bg-green-200 disabled:cursor-not-allowed",
"yellow" => "bg-yellow-600 dark:bg-yellow-400 text-yellow-100 dark:text-yellow-800 hover:bg-yellow-400
dark:hover:bg-yellow-200 active:bg-yellow-400 dark:active:bg-yellow-200 focus:ring-yellow-700 dark:focus:ring-yellow-500
disabled:bg-yellow-300 dark:disabled:bg-yellow-200 disabled:cursor-not-allowed",
"violet" => "bg-violet-600 dark:bg-violet-400 text-violet-100 dark:text-violet-800 hover:bg-violet-400
dark:hover:bg-violet-200 active:bg-violet-400 dark:active:bg-violet-200 focus:ring-violet-700 dark:focus:ring-violet-500
disabled:bg-violet-300 dark:disabled:bg-violet-200 disabled:cursor-not-allowed",
"black" => "bg-black-600 dark:bg-black-400 text-black-100 dark:text-black-800 hover:bg-black-400 dark:hover:bg-black-200
active:bg-black-400 dark:active:bg-black-200 focus:ring-black-700 dark:focus:ring-black-500 disabled:bg-black-300
dark:disabled:bg-black-200 disabled:cursor-not-allowed",
"white" => "bg-gray-50 dark:bg-gray-50 text-gray-800 dark:text-gray-50 hover:bg-gray-50 dark:hover:bg-gray-50
active:bg-gray-50 dark:active:bg-gray-50 focus:ring-gray-50 dark:focus:ring-gray-50 disabled:bg-gray-50
dark:disabled:bg-gray-50 disabled:cursor-not-allowed",
"transparent" => "bg-transparent text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600
active:bg-gray-300 dark:active:bg-gray-700 focus:ring-gray-500 dark:focus:ring-gray-400 disabled:bg-transparent
disabled:cursor-not-allowed",
];

$defaultColor = "gray";
$colorClass = $colors[$color] ?? $colors[$defaultColor];
$buttonClass = "{$classFix} {$colorClass} {$class}";
$defaultText = "Advertencia: Falta contenido en el botón"; // Texto de advertencia si el slot está vacío
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $buttonClass]) }}
  id="{{ $name }}"
  name="{{ $name }}"
  >
  {{ $slot->isEmpty() ? $defaultText : $slot }}
</button>
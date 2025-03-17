{{-- resources/views/components/flash-message.blade.php --}}
@props([
    'messages' => [], // Array de mensajes de sesión
])

@php
    // Definir estilos y íconos según el tipo de mensaje
    $styles = [
        'success' => [
            'bgColor' => 'bg-green-100',
            'borderColor' => 'border-green-400',
            'textColor' => 'text-green-700',
            'iconColor' => 'text-green-500',
            'iconPath' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z',
        ],
        'error' => [
            'bgColor' => 'bg-red-100',
            'borderColor' => 'border-red-400',
            'textColor' => 'text-red-700',
            'iconColor' => 'text-red-500',
            'iconPath' => 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z',
        ],
        'warning' => [
            'bgColor' => 'bg-yellow-100',
            'borderColor' => 'border-yellow-400',
            'textColor' => 'text-yellow-700',
            'iconColor' => 'text-yellow-500',
            'iconPath' => 'M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z',
        ],
        'info' => [
            'bgColor' => 'bg-blue-100',
            'borderColor' => 'border-blue-400',
            'textColor' => 'text-blue-700',
            'iconColor' => 'text-blue-500',
            'iconPath' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z',
        ],
    ];
@endphp

@foreach ($messages as $type => $message)
    @if ($message)
        <div class="{{ $styles[$type]['bgColor'] }} border {{ $styles[$type]['borderColor'] }} {{ $styles[$type]['textColor'] }} px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">{{ ucfirst($type) }}!</strong>
            <span class="block sm:inline">{{ $message }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg onclick="this.parentElement.parentElement.style.display = 'none';"
                    class="fill-current h-6 w-6 {{ $styles[$type]['iconColor'] }}" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path fill-rule="evenodd" d="{{ $styles[$type]['iconPath'] }}" />
                </svg>
            </span>
        </div>
    @endif
@endforeach
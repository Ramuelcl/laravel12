@props(['disabled'=>false, 'rows' => 4, 'cols' => 50, 'placeholder' => 'Enter text here...']
)
<textarea rows="{{ $rows }}" cols="{{ $cols }}" placeholder="{{ $placeholder }}" class="{{ $attributes->merge([
                'class' => "shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"])}}>{{ $slot }}</textarea>

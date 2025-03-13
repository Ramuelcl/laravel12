<!-- resources/views/components/forms/msgErrorsSession.blade.php -->
@props(['errors', 'success'])

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- @dump(session()->all()) -->

@foreach (session()->all() as $key => $messages)

<div class="alert alert-{{ $key }}">
    @if (is_array($messages))
    <ul>
        @foreach ($messages as $message)
        {{-- <li>{{ $message }}</li> --}}
        @endforeach
    </ul>
    @elseif($key !=='_token')
    {{$key}}-{{ $messages }}
    @endif
</div>
@endforeach
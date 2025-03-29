{{-- resources/views/partials/formatTable.blade.php --}}

@foreach ($tables as $campoNombre => $campoInfo)
    @php
        // Obtener el valor del campo actual
        $valorCampo = $data->$campoNombre ?? null;

        // Obtener el tipo de campo desde el arreglo $table
        $tipoCampo = $campoInfo["type"] ?? 'text';

        // Verificar si el campo es visible en la tabla
        $visible = isset($campoInfo["visible"]) && $campoInfo["visible"];
    @endphp

    @if ($visible)
        <td class="border-none px-4 py-1 text-gray-900 dark:text-white">
            @switch($tipoCampo)
                @case('integer')
                    <div class="text-right">
                        {{$valorCampo }}
                    </div>
                    @break

                @case('decimal')
                    <div class="text-right">
                        {{ number_format($valorCampo, $campoInfo["decimal"] ?? 2, '.', ',') }}
                    </div>
                    @break

                @case('date')
                    <div class="text-center">
                        {{ $valorCampo ? date('d/m/Y', strtotime($valorCampo)) : '-' }}
                    </div>
                    @break

                @case('boolean')
                    <div class="text-center">
                        <x-forms.on-off :value="$valorCampo" type="yes/no" />
                    </div>
                    @break

                @case('checkit')
                    <div class="text-center">
                        <x-forms.on-off :valor="$valorCampo" />
                    </div>
                    @break

                @case('tags')
                    <div class="text-center">
                        @if (isset($data->tags) && !$data->tags->isEmpty())
                            @foreach ($data->tags as $tag)
                                <span>{{ $tag->name }}</span>
                                @if (!$loop->last)
                                    -
                                @endif
                            @endforeach
                        @else
                            No tags
                        @endif
                    </div>
                    @break

               @case('select')
    <div class="text-left">
        @php
            $modelName = $campoInfo['model'] ?? null;
            $relatedData = null;

            if ($modelName) {
                // Convertir el nombre del modelo a una variable
                $model = isset($$modelName) ? $$modelName : null;

                if ($model) {
                    // Encuentra el registro cuyo ID coincide con $valorCampo utilizando el modelo dinámico
                    $relatedData = $model::find($valorCampo);
                }
            }
        @endphp
        {{ $relatedData ? $relatedData->name : 'no encontrada' }}
    </div>
    @break

                @case('image')
                    <div class="h-10 w-10 text-center">
                        @if ($valorCampo && Storage::disk('public')->exists($valorCampo))
                            <img alt="Foto" src="{{ asset('storage/' . $valorCampo) }}">
                        @else
                            <span>-</span>
                        @endif
                    </div>
                    @break

                @default
                    <div class="text-left">
                        {{ $valorCampo ?? '-' }}
                    </div>
            @endswitch
        </td>
    @endif
@endforeach
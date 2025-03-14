{{-- resources/views/partials/campos.blade.php --}}
@foreach ($fields as $campoNombre => $campoInfo)
  @php
    // Obtén el valor del campo actual
    $valorCampo = $data->$campoNombre;
    // Obtén el tipo de campo desde el arreglo $fields
    $tipoCampo = $campoInfo["form"]["type"];
    // Verifica si el campo es visible en la tabla
    $visible = $campoInfo["table"]["sortable"] ?? false;
  @endphp

  @if ($visible)
    <td class="border-none px-4 py-1 text-gray-900 dark:text-white">
      @switch($tipoCampo)
        @case("integer")
        @case("decimal")
          <div class="text-right">
            {{ number_format($valorCampo, $campoInfo["form"]["decimal"] ?? 2, ".", ",") }}
          </div>
        @break

        @case("date")
          <div class="text-center">
            {{ date("d/m/Y", strtotime($valorCampo)) }}
          </div>
        @break

        @case("checkit")
          <div class="text-center">
            <x-forms.tw_onoff :valor="$valorCampo" tipo="ticket-x" />
          </div>
        @break

        @case("tags")
          <div class="text-center">
            @if ($data->tags->isEmpty())
              No tags
            @else
              @foreach ($data->tags as $tag)
                <span>{{ $tag->name }}</span>
                @if (!$loop->last)
                  -
                @endif
              @endforeach
            @endif
          </div>
        @break

        @case("select")
          <div class="text-left">
            @php
              // Encuentra la categoría cuyo ID coincide con $valorCampo
              $category = $categorias->firstWhere("id", $valorCampo);
            @endphp
            {{ $category ? $category->name : "no encontrada" }}
          </div>
        @break

        @case("image")
          <div class="h-10 w-10 text-center">
            @if (!is_null($valorCampo) && Storage::disk("public")->exists($valorCampo))
              <img alt="Foto" src="{{ asset("storage/" . $valorCampo) }}">
            @endif
          </div>
        @break

        @default
          <div class="text-left">
            {{ $valorCampo }}
          </div>
      @endswitch
    </td>
  @endif
@endforeach

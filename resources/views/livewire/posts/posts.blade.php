<?php // resources/views/livewire/posts/posts.blade.php

use App\Models\Post\Post as Data;
use App\Models\backend\Category;
use Livewire\Volt\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    public $fields = [
        "id" => [
            "Id",
            "table" => ["sortable" => true, "visible" => true],
            "form" => [
                "type" => "text",
                "disabled" => true,
            ],
        ],
        "title" => [
            "Title",
            "table" => ["sortable" => true, "visible" => true],
            "form" => [
                "type" => "text",
                "placeholder" => "Ingrese el título",
            ],
        ],
        "content" => [
            "Content",
            "table" => ["sortable" => false, "visible" => true], // Deshabilitar ordenamiento para este campo
            "form" => [
                "type" => "textarea",
                "placeholder" => "Ingrese el contenido",
            ],
        ],
        "category_id" => [
            "Category",
            "table" => ["sortable" => true, "visible" => true],
            "form" => [
                "type" => "select",
                "placeholder" => "Seleccione una categoría",
            ],
        ],
        "state" => [
            "Status",
            "table" => ["sortable" => true, "visible" => true],
            "form" => [
                "type" => "select",
                "hidden" => true,
                "placeholder" => "", // Placeholder vacío
            ],
        ],
        "user_id" => [
            "User",
            "table" => ["sortable" => true, "visible" => true],
            "form" => [
                "type" => "text",
                "hidden" => true,
                "placeholder" => "", // Placeholder vacío
            ],
        ],
        "created_at" => [
            "Created At",
            "table" => ["sortable" => true, "visible" => true],
            "form" => [
                "type" => "date",
                "disabled" => true,
                "placeholder" => "", // Placeholder vacío
            ],
        ],
    ];

    public $crudl = "list"; // create, read, update, delete, list
    public $model = Data::class;

    public $titles, $tables, $forms;
    public $datas = [];
    public $categorias = [];
    public $selectedCategories = []; // Opciones seleccionadas
    protected $listeners = ["selected-updated" => "handleSelectedUpdated"];
    public $sortField = "title";
    public $sortDirection = "asc";
    public $formData = [];

    // Método para manejar las opciones seleccionadas
    public function handleSelectedUpdated($selected)
    {
        $this->selectedCategories = $selected;
    }

    public function mount()
    {
        // Obtener las categorías desde la base de datos
        $this->categorias = Category::pluck("name", "id")->toArray();

        $this->titles = array_column($this->fields, 0);
        $this->tables = array_map(
            function ($key, $field) {
                return ["title" => $field[0], "data" => $field["table"]];
            },
            array_keys($this->fields),
            $this->fields,
        );
        $this->forms = array_map(
            function ($key, $field) {
                return ["title" => $field[0], "data" => $field["form"]];
            },
            array_keys($this->fields),
            $this->fields,
        );

        $this->getData();

        foreach ($this->fields as $key => $field) {
            $this->formData[$key] = $field["form"]["default"] ?? null;
        }

        // Asignar el ID del usuario autenticado al campo `user_id`
        if (auth()->check()) {
            $this->formData["user_id"] = auth()->user()->id;
        }
    }

    public function getData()
    {
        $this->datas = $this->model::orderBy($this->sortField, $this->sortDirection)->get();
    }

    public function sortBy($field)
    {
        // Verificar si hay registros en la tabla
        if ($this->datas->isEmpty()) {
            session()->flash("warning", "No hay registros para ordenar.");
            return;
        }

        // Lógica de ordenamiento
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === "asc" ? "desc" : "asc";
        } else {
            $this->sortDirection = "asc";
        }
        $this->sortField = $field;
        $this->getData();
    }

    public function addRecord()
    {
        $this->crudl = "create";
    }

    public function saveRecord()
    {
        $this->model::create($this->formData);
        $this->crudl = "list";
        $this->getData();
    }

    public function cancelRecord()
    {
        $this->crudl = "list";
    }
};
?>

<div>
  @if ($crudl === "list")
    <div class="pb-2">
      <button wire:click="addRecord()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Agregar Registro
      </button>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">
        {{-- TITULOS --}}
        <thead
          class="bg-neutral text-gray-700 dark:bg-neutral-800 dark:text-gray-300 -50 text-xs uppercase font-semibold tracking-wide">
          <tr>
            @foreach ($tables as $key => $table)
              <th
                class="px-6 py-3 border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 text-left text-xs uppercase font-semibold {{ $table["data"]["sortable"] ? "cursor-pointer" : "" }}"
                @if ($table["data"]["sortable"]) wire:click="sortBy('{{ $key }}')" @endif>
                <span class="flex items-center justify-start">
                  <span class="mr-2">{{ __($table["title"]) }}</span>
                  @if ($table["data"]["sortable"])
                    <span class="w-4 h-4">
                      @if ($sortField === $key)
                        <x-icons.sort :direction="$sortDirection" />
                      @else
                        <x-icons.sort />
                      @endif
                    </span>
                  @endif
                </span>
              </th>
            @endforeach
          </tr>
        </thead>
        {{-- CUERPO --}}
        <tbody>
          @if ($datas->isNotEmpty())
            @foreach ($datas as $data)
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                @foreach ($fields as $campoNombre => $campoInfo)
                  @php
                    // Obtén el valor del campo actual
                    $valorCampo = $data->$campoNombre;
                    // Obtén el tipo de campo desde el arreglo $fields
                    $tipoCampo = $campoInfo["form"]["type"];
                    // Verifica si el campo es visible en la tabla
                    $visible = $campoInfo["table"]["visible"] ?? false;
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
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="{{ count($titles) }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                No hay datos disponibles.
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  @else
    <flux:heading>
      <flux:subheading>
        {{ $crudl == "create" ? __("new") : ($crudl == "update" ? __("update") : __("delete")) }} {{ __("record") }}
      </flux:subheading>
      <flux:separator variant="subtle" class="mb-4" />
      <div>
        <form wire:submit="saveRecord">
          @foreach ($forms as $key => $form)
            <div class="mb-4">
              {{-- INPUTS --}}
              {{-- TEXTAREA --}}
              @if ($form["data"]["type"] === "textarea")
                <flux:textarea label="{{ $form["title"] }}" id="{{ $key }}" name="{{ $key }}"
                  wire:model="formData.{{ $key }}" class="w-full" />
                {{-- SELECT --}}
              @elseif ($form["data"]["type"] === "select")
                <x-forms.input-select id="{{ $key }}" wire:model="formData.{{ $key }}"
                  label="{{ $form["title"] }}" :options="$categorias" :selected="$selectedCategories" labelWidth="w-1/4"
                  inputWidth="w-3/4" />
                {{-- DATE --}}
              @elseif ($form["data"]["type"] === "date")
                <flux:input type="date" wire:model="formData.{{ $key }}" id="{{ $key }}"
                  @if (isset($form["data"]["disabled"]) && $form["data"]["disabled"] === true) disabled @endif />
                {{-- TEXT --}}
              @elseif ($form["data"]["type"] === "text")
                <flux:input type="text" label="{{ $form["title"] }}" wire:model="formData.{{ $key }}"
                  id="{{ $key }}" class="w-full" placeholder="{{ $form["data"]["placeholder"] ?? "" }}"
                  @if (isset($form["data"]["disabled"]) && $form["data"]["disabled"]) disabled @endif />
              @endif
            </div>
          @endforeach
          <button type="submit"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
          <button type="button" wire:click="cancelRecord"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</button>
        </form>
      </div>
    </flux:heading>
  @endif
</div>

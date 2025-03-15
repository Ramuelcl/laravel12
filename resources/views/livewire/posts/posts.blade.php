<?php // resources/views/livewire/posts/posts.blade.php

use App\Models\Post\Post as Data;
use App\Models\backend\Category as Data1;
use Livewire\Volt\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    public $fields = [
        "id" => [
            "table" => ["title" => "Id", "sortable" => true, "visible" => true, "type" => "text"],
            "form" => ["title" => "Id", "type" => "text", "disabled" => true],
        ],
        "title" => [
            "table" => ["title" => "Title", "sortable" => true, "visible" => true, "type" => "text"],
            "form" => ["title" => "Title", "type" => "text", "placeholder" => "Ingrese el título"],
        ],
        "content" => [
            "table" => ["title" => "Content", "sortable" => false, "visible" => true, "type" => "text"],
            "form" => ["title" => "Content", "type" => "textarea", "placeholder" => "Ingrese el contenido"],
        ],
        "category_id" => [
            "table" => ["title" => "Category", "sortable" => true, "visible" => true, "type" => "select"],
            "form" => ["title" => "Category", "type" => "select", "placeholder" => "Seleccione una categoría"],
        ],
        "state" => [
            "table" => ["title" => "Status", "sortable" => true, "visible" => true, "type" => "boolean"],
            "form" => ["title" => "Status", "type" => "select", "hidden" => true, "placeholder" => ""],
        ],
        "user_id" => [
            "table" => ["title" => "User", "sortable" => true, "visible" => true, "type" => "text"],
            "form" => ["title" => "User", "type" => "text", "hidden" => true, "placeholder" => ""],
        ],
        "created_at" => [
            "table" => ["title" => "Created At", "sortable" => true, "visible" => true, "type" => "date"],
            "form" => ["title" => "Created At", "type" => "date", "disabled" => true, "placeholder" => ""],
        ],
    ];

    public $crudl = "list"; // create, read, update, delete, list
    public $model = Data::class;
    public $model1 = Data1::class;

    public $tables, $forms;
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
        $this->categorias = $this->model1::pluck("name", "id")->toArray();

        // Extraer los subarreglos "table" y "form"
        $this->tables = array_combine(
            array_keys($this->fields),
            array_map(function ($field) {
                return $field["table"];
            }, $this->fields),
        );

        $this->forms = array_combine(
            array_keys($this->fields),
            array_map(function ($field) {
                return $field["form"];
            }, $this->fields),
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
                class="px-6 py-3 border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 text-left text-xs uppercase font-semibold {{ $table["sortable"] ? "cursor-pointer" : "" }}"
                @if ($table["sortable"]) wire:click="sortBy('{{ $key }}')" @endif>
                <span class="flex items-center justify-start">
                  <span class="mr-2">{{ __($table["title"]) }}</span>
                  @if ($table["sortable"])
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
                @include("partials.camposTable", [
                    "table" => $tables,
                    "data" => $data,
                    "data1" => $this->model1, // Agregar el modelo de la categoría
                ])
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="{{ count($tables) }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
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
              @if ($form["type"] === "textarea")
                <flux:textarea label="{{ $form["title"] }}" id="{{ $key }}" name="{{ $key }}"
                  wire:model="formData.{{ $key }}" class="w-full" />
                {{-- SELECT --}}
              @elseif ($form["type"] === "select")
                <x-forms.input-select id="{{ $key }}" wire:model="formData.{{ $key }}"
                  label="{{ $form["title"] }}" :options="$categorias" :selected="$selectedCategories" labelWidth="w-1/4"
                  inputWidth="w-3/4" />
                {{-- DATE --}}
              @elseif ($form["type"] === "date")
                <flux:input type="date" wire:model="formData.{{ $key }}" id="{{ $key }}"
                  @if (isset($form["disabled"]) && $form["disabled"] === true) disabled @endif />
                {{-- TEXT --}}
              @elseif ($form["type"] === "text")
                <flux:input type="text" label="{{ $form["title"] }}" wire:model="formData.{{ $key }}"
                  id="{{ $key }}" class="w-full" placeholder="{{ $form["placeholder"] ?? "" }}"
                  @if (isset($form["disabled"]) && $form["disabled"]) disabled @endif />
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

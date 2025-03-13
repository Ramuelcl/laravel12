<?php // resources/views/livewire/posts/posts.blade.php

use App\Models\Post\Post as Data;
use App\Models\backend\Category;
use Livewire\Volt\Component;
use Illuminate\Support\Str;

new class extends Component {
    public $fields = [
        "title" => [
            "Title",
            "table" => ["sortable" => true],
            "form" => [
                "type" => "text",
                "placeholder" => "Ingrese el título", // Placeholder personalizado
            ],
        ],
        "content" => [
            "Content",
            "table" => ["sortable" => false], // Deshabilitar ordenamiento para este campo
            "form" => [
                "type" => "textarea",
                "placeholder" => "Ingrese el contenido", // Placeholder personalizado
            ],
        ],
        "category_id" => [
            "Category",
            "table" => ["sortable" => true],
            "form" => [
                "type" => "select",
                "placeholder" => "Seleccione una categoría", // Placeholder personalizado
            ],
        ],
        "state" => [
            "Status",
            "table" => ["sortable" => true],
            "form" => [
                "type" => "select",
                "hidden" => true,
                "placeholder" => "", // Placeholder vacío
            ],
        ],
        "user_id" => [
            "User",
            "table" => ["sortable" => true],
            "form" => [
                "type" => "text",
                "hidden" => true,
                "placeholder" => "", // Placeholder vacío
            ],
        ],
        "created_at" => [
            "Created At",
            "table" => ["sortable" => true],
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
    // Escuchar el evento "selected-updated"
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
        // dd($this->categorias);

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
        <tbody>
          @if ($datas->isNotEmpty())
            @foreach ($datas as $data)
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">{{ $data->title }}</td>
                <td class="px-6 py-4">{{ Str::limit($data->content, 50) }}</td>
                <td class="px-6 py-4">{{ $data->category->name ?? "N/A" }}</td>
                <!-- Mostrar el nombre de la categoría -->
                <td class="px-6 py-4">{{ $data->user_id }}</td>
                <td class="px-6 py-4">{{ $data->state }}</td>
                <td class="px-6 py-4">{{ $data->created_at }}</td>
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
              {{-- LABEL --}}
              @if (!isset($form["data"]["hidden"]) || $form["data"]["hidden"] !== true)
                <label for="{{ $key }}">{{ $form["title"] }}</label>
              @endif

              {{-- INPUT --}}
              {{-- tipos de ingreso --}}
              {{-- TEXTAREA --}}
              @if ($form["data"]["type"] === "textarea")
                <livewire:components.input :label="$form["title"]" :id="$key" :name="$key"
                  :value="$formData[$key]" :class="$form["data"]["class"]" />
                <textarea wire:model="formData.{{ $key }}" id="{{ $key }}"
                  placeholder="{{ $form["data"]["placeholder"] ?? "" }}"></textarea>
                {{-- SELECT --}}
              @elseif ($form["data"]["type"] === "select")
                <livewire:components.input :options="$categorias" :selected="$crudl === 'create' ? [] : $selectedCategories" />
                {{-- DATE --}}
              @elseif ($form["data"]["type"] === "date")
                <input type="date" wire:model="formData.{{ $key }}" id="{{ $key }}"
                  @if (isset($form["data"]["disabled"]) && $form["data"]["disabled"] === true) disabled @endif title="{{ $form["data"]["placeholder"] ?? "" }}">
                {{-- HIDDEN --}}
              @elseif (isset($form["data"]["hidden"]) && $form["data"]["hidden"] === true)
                <input type="hidden" wire:model="formData.{{ $key }}" id="{{ $key }}">
                {{-- TEXT --}}
              @else
                <x-tw-input type="text" label="{{ $form["title"] }}" wire:model="formData.{{ $key }}"
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

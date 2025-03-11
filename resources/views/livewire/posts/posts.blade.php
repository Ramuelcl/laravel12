<?php
// resources/views/livewire/posts/posts.blade.php
use App\Models\post\Post as Data;
use Livewire\Volt\Component;
use Illuminate\Support\Str;

new class extends Component {
    public $fields = [
        // title
        "title" => ["Title", "table" => ["sortable" => true, "view" => true, "type" => "text"], "form" => ["type" => "text", "disabled" => false, "default" => ""]],
        // content
        "content" => ["Content", "table" => ["sortable" => true, "view" => true, "type" => "textarea"], "form" => ["type" => "textarea", "disabled" => false, "default" => ""]],
        // category_id
        "category_id" => ["Category", "table" => ["sortable" => false, "view" => true, "type" => "select"], "form" => ["type" => "select", "disabled" => false, "default" => "0"]],
        // user_id
        "user_id" => ["User", "table" => ["sortable" => true, "view" => true, "type" => "select"], "form" => ["type" => "select", "disabled" => false, "default" => ""]],
        // state
        "state" => ["Status", "table" => ["sortable" => true, "view" => true, "type" => "boolean"], "form" => ["type" => "select", "disabled" => false, "default" => ""]],
        // created_at
        "created_at" => ["Created At", "table" => ["sortable" => true, "view" => true, "type" => "date"], "form" => ["type" => "date", "disabled" => true, "default" => ""]],
    ];
    public $crudl = "list"; // create, read, update, delete, list
    public $model = Data::class;

    public $titles, $tables, $forms;
    public $datas = [];
    public $sortField = "title";
    public $sortDirection = "asc";
    public $formData = [];

    public function mount()
    {
        $this->getData();
        // Extraer los títulos y nombres de los campos
        // $index = 0;
        $this->titles = array_map(
            function ($field, $key) {
                //use (&$index)
                return [
                    "name" => $key,
                    "title" => $field[0],
                    // "index" => $index++,
                ];
            },
            $this->fields,
            array_keys($this->fields),
        );
        $this->tables = array_column($this->fields, "table");
        $this->forms = array_column($this->fields, "form");

        // dd($this->titles, $this->tables, $this->forms);

        $this->getData();

        // Inicializar formData con valores por defecto
        foreach ($this->fields as $key => $field) {
            if (isset($field["form"]["default"])) {
                $this->formData[$key] = $field["form"]["default"];
            } else {
                $this->formData[$key] = "";
            }
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
  @if ($this->crudl === "list")
    <div>
      <button wire:click="addRecord" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Agregar Registro
      </button>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">
        <thead
          class="bg-neutral text-gray-700 dark:bg-neutral-800 dark:text-gray-300 text-xs uppercase font-semibold tracking-wide">
          <tr>
            {{-- @dd($this->titles) --}}
            @foreach ($this->titles as $key => $title)
              <th
                class="px-6 py-3 border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 text-left text-xs uppercase font-semibold cursor-pointer"
                wire:click="sortBy('{{ $key }}')">
                <span class="flex items-center justify-start">
                  <span class="mr-2">{{ __($title["title"]) }}</span>
                  <span class="w-4 h-4">
                    @if ($this->sortField === $key)
                      <x-icons.sort :direction="$this->sortDirection" />
                    @else
                      <x-icons.sort />
                    @endif
                  </span>
                </span>
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @if ($this->datas->isNotEmpty())
            @foreach ($this->datas as $data)
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">{{ $data->title }}</td>
                <td class="px-6 py-4">{{ Str::limit($data->content, 25) }}</td>
                <td class="px-6 py-4">{{ $data->category_id }}</td>
                <td class="px-6 py-4">{{ $data->user_id }}</td>
                <td class="px-6 py-4">{{ $data->state }}</td>
                <td class="px-6 py-4">{{ $data->created_at }}</td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="{{ count($this->fields) }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                No hay datos disponibles.
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  @else
    <div>
      <form wire:submit.prevent="saveRecord">
        {{-- @csrf --}}
        @dd($this->forms, $this->titles)
        @foreach ($this->titles as $key => $field)
          <div>
            <label for="{{ $key }}">{{ $field["title"] }}</label>
            @if ($forms[$key]["type"] === "text")
              <input type="text" wire:model="{{ $field["name"] }}" id="{{ $key }}">
            @elseif ($field[1]["form"]["type"] === "textarea")
              <textarea wire:model="{{ $field["name"] }}" id="{{ $key }}"></textarea>
            @elseif ($field[1]["form"]["type"] === "select")
              <select wire:model="{{ $field["name"] }}" id="{{ $key }}">
                <option value="">Seleccione...</option>
                {{-- Aquí puedes agregar las opciones del select --}}
              </select>
            @elseif ($field[1]["form"]["type"] === "date")
              <input type="date" wire:model="{{ $field["name"] }}" id="{{ $key }}"
                @if (isset($field[1]["form"]["enabled"]) && $field[1]["form"]["enabled"] === false) disabled @endif>
            @endif
          </div>
        @endforeach
        <button type="submit"
          class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
        <button type="button" wire:click="cancelRecord"
          class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancelar</button>
      </form>
    </div>
  @endif
</div>

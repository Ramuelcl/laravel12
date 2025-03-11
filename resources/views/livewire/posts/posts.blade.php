<?php
// resources/views/livewire/posts/posts.blade.php

use App\Models\post\Post as Data;
use Livewire\Volt\Component;
use Illuminate\Support\Str;

new class extends Component {
    public $fields = [
        "title" => ["Title", "table" => ["sortable" => true], "form" => ["type" => "text"]],
        "content" => ["Content", "table" => ["sortable" => true], "form" => ["type" => "textarea"]],
        "category_id" => ["Category", "table" => ["sortable" => true], "form" => ["type" => "select"]],
        "user_id" => ["User", "table" => ["sortable" => true], "form" => ["type" => "select"]],
        "state" => ["Status", "table" => ["sortable" => true], "form" => ["type" => "select"]],
        "created_at" => ["Created At", "table" => ["sortable" => true], "form" => ["type" => "date", "enabled" => false]],
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
        $this->titles = array_column($this->fields, 0);
        $this->tables = array_map(function ($field) {
            return ["title" => $field[0], "data" => $field[1]];
        }, $this->fields);
        $this->forms = array_map(function ($field) {
            return ["title" => $field[0], "data" => $field[2]];
        }, $this->fields);
        $this->getData();
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
  @if ($crudl === "list")
    <div>
      <button wire:click="addRecord()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Agregar Registro
      </button>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">
        <thead
          class="bg-neutral text-gray-700 dark:bg-neutral-800 dark:text-gray-300 -50 text-xs uppercase font-semibold tracking-wide">
          <tr>
            @foreach ($tables as $index => $table)
              <th
                class="px-6 py-3 border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 text-left text-xs uppercase font-semibold cursor-pointer"
                wire:click="sortBy('{{ array_keys($fields)[$index] }}')">
                <span class="flex items-center justify-start">
                  <span class="mr-2">{{ __($table["title"]) }}</span>
                  <span class="w-4 h-4">
                    @if ($sortField === array_keys($fields)[$index])
                      <x-icons.sort :direction="$sortDirection" />
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
          @if ($datas->isNotEmpty())
            @foreach ($datas as $data)
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">{{ $data->title }}</td>
                <td class="px-6 py-4">{{ Str::limit($data->content, 50) }}</td>
                <td class="px-6 py-4">{{ $data->category_id }}</td>
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
    <div>
      <form wire:submit="saveRecord">
        @foreach ($forms as $key => $form)
          <div>
            <label for="{{ array_keys($fields)[$key] }}">{{ $form["title"] }}</label>
            @if ($form["data"]["type"] === "text")
              <input type="text" wire:model="formData.{{ array_keys($fields)[$key] }}"
                id="{{ array_keys($fields)[$key] }}">
            @elseif ($form["data"]["type"] === "textarea")
              <textarea wire:model="formData.{{ array_keys($fields)[$key] }}" id="{{ array_keys($fields)[$key] }}"></textarea>
            @elseif ($form["data"]["type"] === "select")
              <select wire:model="formData.{{ array_keys($fields)[$key] }}" id="{{ array_keys($fields)[$key] }}">
                <option value="">Seleccione...</option>
                {{-- Aquí puedes agregar las opciones del select --}}
              </select>
            @elseif ($form["data"]["type"] === "date")
              <input type="date" wire:model="formData.{{ array_keys($fields)[$key] }}"
                id="{{ array_keys($fields)[$key] }}" @if (isset($form["data"]["enabled"]) && $form["data"]["enabled"] === false) disabled @endif>
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

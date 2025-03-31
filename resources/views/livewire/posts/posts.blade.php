<?php
// filepath: c:\laragon\www\laravel\laravel12\resources\views\livewire\posts\posts.blade.php

use App\Models\Backend\Category as Data1; // Modelo de categorías
use App\Models\User as Data2; // Modelo de categorías
use App\Models\Post\Post as Data;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
// use App\Models\backend\Tag as Data3; // Modelo de etiquetas
new class extends Component {
    use withFileUploads, WithPagination;

    public $crudl = 'list'; // create, read, update, delete, list
    public $model = Data::class; // Modelo principal
    public $model1 = Data1::class; // Modelo de categorías
    public $model2 = Data2::class; // Modelo de usuarios
    public $fields, $tables, $forms, $rules, $messages, $validationAttributes;
    public $datas = [];
    public $image;

    public $categorias = [];
    public $selectedCategories = []; // Opciones seleccionadas
    public $sortField = 'id';
    public $sortDirection = 'desc';
    // filtro si existe el campo
    public $is_Active = false;
    public $activeFilter = ''; // '' (todos), 1 (activos), 0 (inactivos)
    public $activeCount = 1;

    public $filterButtonText = 'Actives';

    public $formData = [];
    public $subTitle = 'List Records';
    public $headerClass = 'px-6 py-3 border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 text-left text-xs font-semibold tracking-wide';
    public $classInput = 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm';

    public function mount()
    {
        // Cargar los campos desde la configuración
        $this->fields = config('camposPost');
        if (empty($this->fields)) {
            throw new \Exception("Los campos no están configurados correctamente en 'config/camposPost'.");
        }

        // Obtener las categorías desde la base de datos
        $this->categorias = $this->model1::pluck('name', 'id')->toArray();

        // Extraer los subarreglos "table" y "form"
        $this->tables = array_combine(
            array_keys($this->fields),
            array_map(function ($field) {
                return $field['table'] + ['visible' => $field['table']['visible'] ?? false]; // Asegurar la clave 'visible'
            }, $this->fields),
        );

        $this->forms = array_combine(
            array_keys($this->fields),
            array_map(function ($field) {
                return $field['form'];
            }, $this->fields),
        );

        // Inicializar form con valores predeterminados
        foreach ($this->fields as $key => $field) {
            $this->formData[$key] = $field['form']['default'] ?? null;
            if ($key === 'is_active') {
                $this->is_Active = true;
            }
        }

        // Asignar el ID del usuario autenticado al campo `user_id`
        if (auth()->check()) {
            $this->formData['user_id'] = auth()->user()->id;
        }

        // Cargar los datos iniciales
        $this->getData();
    }

    public function rules()
    {
        $rules = [];
        foreach ($this->fields as $key => $field) {
            if (isset($field['rule'])) {
                $rules[$key] = $field['rule'];
            } else {
                $rules[$key] = []; // Agregar un array vacío si no hay reglas
            }
        }
        // dd($rules);
        return $rules;
    }

    public function getData()
    {
        $query = $this->model::with(['category', 'user']);

        if ($this->activeFilter !== '') {
            $query->where('is_active', $this->activeFilter);
        }

        // Cargar las relaciones 'category' y 'user' junto con los posts
        $this->datas = $query->orderBy($this->sortField, $this->sortDirection)->get();
    }

    public function filtreActive()
    {
        if ($this->activeCount == 1) {
            $this->activeFilter = '1';
            $this->filterButtonText = 'Inactives';
        } elseif ($this->activeCount == 2) {
            $this->activeFilter = '0';
            $this->filterButtonText = 'All';
        } else {
            $this->activeCount = 0;
            $this->activeFilter = '';
            $this->filterButtonText = 'Active';
        }
        $this->activeCount++;

        $this->getData();
    }

    public function sortBy($field)
    {
        // Verificar si hay registros en la tabla
        if ($this->datas->isEmpty()) {
            session()->flash('warning', 'No hay registros para ordenar.');
            return;
        }

        // Lógica de ordenamiento
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
        $this->getData();
    }

    public function saveRecord()
    {
        if ($this->crudl === 'create' || $this->crudl === 'update') {
            // Validar los datos del formulario
            $rules = $this->rules ?? [];
            $messages = $this->messages ?? [];
            $validationAttributes = $this->validationAttributes ?? [];

            $validated = $this->validate($rules, $messages, $validationAttributes);

            // Generar el slug si es necesario
            if (empty($this->formData['slug'])) {
                $this->formData['slug'] = Str::slug($this->formData['title']);
            }

            // Verificar si el slug ya existe (excepto para el registro actual al editar)
            $slugExists = Data::where('slug', $this->formData['slug'])
                ->when($this->crudl === 'update', function ($query) {
                    return $query->where('id', '!=', $this->formData['id']);
                })
                ->exists();

            if ($slugExists) {
                $this->addError('formData.slug', 'El slug ya existe. Debe ser único.');
                return;
            }

            if ($this->image) {
                $imageName = time() . '.' . $this->image->extension();
                $this->image->storeAs('images/posts', $imageName, 'public');
                $validated['image_path'] = $imageName;
            }

            // Guardar o actualizar el registro
            if ($this->crudl === 'create') {
                $this->model::create($validated);
            } elseif ($this->crudl === 'update') {
                $this->model::find($this->formData['id'])->update($validated);
            }
        }

        // Volver al listado
        $this->crudl = 'list';
        $this->getData();
    }

    public function addRecord()
    {
        $this->crudl = 'create';
        $this->subtitle();
    }

    public function cancelRecord()
    {
        $this->crudl = 'list';
        $this->subtitle();
        $this->getData();
    }

    public function editRecord($id)
    {
        $record = $this->model::find($id);

        if ($record) {
            if (auth()->user()->id !== $record->user_id) {
                session()->flash('error', 'You are not authorized to edit this record.');
                return;
            }

            // Convertir el modelo a un array asociativo
            $recordArray = $record->toArray();

            // Iterar sobre los campos del formulario
            foreach ($this->forms as $key => $form) {
                // Verificar si el campo existe en el registro
                if (array_key_exists($key, $recordArray)) {
                    // Asignar el valor del registro al campo del formulario
                    $this->formData[$key] = $recordArray[$key];
                }
            }
            // dd($this->formData);
            $this->crudl = 'update';
            $this->subtitle();
        } else {
            session()->flash('error', 'Record not found.');
        }
    }

    public function showRecord($id)
    {
        $record = $this->model::find($id)->toArray();
        foreach ($record as $key => $value) {
            if (isset($this->formData[$key])) {
                $this->formData[$key] = $value;
            }
        }
        $this->crudl = 'read';
        $this->subtitle();
    }

    public function deleteRecord($id)
    {
        $record = $this->model::find($id)->toArray();
        foreach ($record as $key => $value) {
            if (isset($this->formData[$key])) {
                $this->formData[$key] = $value;
            }
        }
        $this->crudl = 'delete';
        $this->subtitle();
    }

    public function confirmDelete()
    {
        $this->model::find($this->formData['id'])->delete();
        $this->crudl = 'list';
        $this->subtitle();
        $this->getData();
    }

    public function subtitle()
    {
        $this->subTitle = $this->crudl . ' record' . ($this->crudl === 'list' ? '(s)' : '') . ($this->crudl === 'delete' ? ' - Are you sure?' : '');
    }
};
?>
<div>
  <div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Posts') }}</flux:heading>
    <flux:subheading size="lg" class="mb-3 {{ $this->crudl === 'delete' ? 'text-red-800 font-extrabold' : '' }}">
      {{ __($subTitle) }}
    </flux:subheading>
    <flux:separator variant="subtle" />
  </div>

  @if ($crudl === 'list')
    <!-- Tabla de listado -->
    <div class="overflow-x-auto">
      <div class="pb-2 flex justify-between">
        <div>
          <button wire:click="addRecord()"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
            {{ __('new Record') }}
          </button>
        </div>
        @if ($is_Active)
          <div>
            <div>
              <button wire:click="filtreActive()"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                {{ __($filterButtonText) }}
              </button>
            </div>
          </div>
        @endif
      </div>
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 whitespace-nowrap">
        <thead
          class="bg-neutral text-gray-700 dark:bg-neutral-800 dark:text-gray-300 -50 text-xs font-semibold tracking-wide">
          <tr>
            @foreach ($tables as $key => $table)
              @if ($table['visible'])
                <th scope="col"
                  class="{{ $headerClass }} cursor-pointer {{ $table['sortable'] ? 'uppercase' : 'capitalize' }}"
                  wire:click="{{ $table['sortable'] ? 'sortBy(\'' . $key . '\')' : '' }}">
                  {{ __($table['title']) }}
                  @if ($sortField === $key)
                    <span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                  @endif
                </th>
              @endif
            @endforeach
          </tr>
        </thead>
        <tbody>
          @if ($datas->isNotEmpty())
            @foreach ($datas as $data)
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                @include('partials.formatTable', ['data' => $data, 'tables' => $tables])
                <td class="border-none px-4 py-1 text-center text-gray-900 dark:text-white">
                  <button wire:click="editRecord({{ $data->id }})"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                    {{ __('Edit') }}
                  </button>
                  <button wire:click="showRecord({{ $data->id }})"
                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                    {{ __('Read') }}
                  </button>
                  <button wire:click="deleteRecord({{ $data->id }})"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                    {{ __('Delete') }}
                  </button>
                </td>
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
    <!-- Formulario dinámico -->
    <form wire:submit.prevent="saveRecord">
      <fieldset {{ $crudl === 'read' || $crudl === 'delete' ? 'disabled' : '' }}>
        <div class="space-y-4">
          @foreach ($forms as $key => $form)
            @if ($form['visibility'][$crudl] ?? false)
              <div>
                <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  {{ __($form['title']) }}
                </label>
                {{-- TEXT --}}
                @if ($form['type'] === 'text')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- NUMBER --}}
                @elseif ($form['type'] === 'number')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- EMAIL --}}
                @elseif ($form['type'] === 'email')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- PASSWORD --}}
                @elseif ($form['type'] === 'password')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- CHECKBOX --}}
                @elseif ($form['type'] === 'checkbox')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- RADIO --}}
                @elseif ($form['type'] === 'radio')
                  @foreach ($form['options'] as $option)
                    <div>
                      <input type="{{ $form['type'] }}" id="{{ $key }}_{{ $option }}"
                        wire:model="formData.{{ $key }}" value="{{ $option }}"
                        {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                      <label for="{{ $key }}_{{ $option }}">{{ __($option) }}</label>
                    </div>
                  @endforeach
                  {{-- FILE --}}
                @elseif ($form['type'] === 'file')
                  <div class="flex items-center">
                    <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="image"
                      placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                      {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                    @if ($image)
                      <img src="{{ $image->temporaryUrl() }}" alt="Image" width="100">
                    @elseif ($formData['image_path'])
                      <img src="{{ asset('storage/images/posts/' . $formData['image_path']) }}" alt="Image"
                        width="100">
                    @endif
                  </div>
                  {{-- DATE --}}
                @elseif ($form['type'] === 'date')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- DATETIME --}}
                @elseif ($form['type'] === 'datetime')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- TIME --}}
                @elseif ($form['type'] === 'time')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- COLOR --}}
                @elseif ($form['type'] === 'color')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- TEL --}}
                @elseif ($form['type'] === 'tel')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- URL --}}
                @elseif ($form['type'] === 'url')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                  {{-- TEXTAREA --}}
                @elseif ($form['type'] === 'textarea')
                  <textarea id="{{ $key }}" wire:model="formData.{{ $key }}"
                    placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                    {{ $form['disabled'] ?? false ? 'disabled' : '' }}></textarea>
                  {{-- SELECTWITHOPTIONS --}}
                @elseif ($form['type'] === 'selectWithOptions')
                  <select id="{{ $key }}" wire:model="formData.{{ $key }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                    <option value="" disabled>{{ __('select') }}</option>
                    @if (isset($form['options']))
                      @foreach ($form['options'] as $optionKey => $optionValue)
                        <option value="{{ $optionKey }}" @if (isset($formData[$key]) && (string) $formData[$key] === (string) $optionKey) selected @endif>
                          {{ $optionValue }}</option>
                      @endforeach
                    @endif
                  </select>
                  {{-- SELECTWITHMODEL --}}
                @elseif ($form['type'] === 'selectWithModel')
                  <select id="{{ $key }}" wire:model="formData.{{ $key }}"
                    class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                    <option value="" disabled>{{ __('select') }}</option>
                    @if ($key === 'user_id')
                      @foreach ($this->model2::pluck('name', 'id') as $id => $name)
                        <option value="{{ $id }}" @if (isset($formData[$key]) && $formData[$key] == $id) selected @endif>
                          {{ $name }}</option>
                      @endforeach
                    @endif
                    {{-- SELECT --}}
                  @elseif ($form['type'] === 'select')
                    <select id="{{ $key }}" wire:model="formData.{{ $key }}"
                      class="{{ $classInput }}" {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
                      <option value="" disabled>{{ __('select') }}</option>
                      @if ($key === 'category_id')
                        @foreach ($categorias as $id => $name)
                          <option value="{{ $id }}" @if (isset($formData[$key]) && $formData[$key] == $id) selected @endif>
                            {{ $name }}</option>
                        @endforeach
                      @elseif (isset($form['options']))
                        @foreach ($form['options'] as $optionKey => $optionValue)
                          <option value="{{ $optionKey }}" @if (isset($formData[$key]) && $formData[$key] == $optionKey) selected @endif>
                            {{ $optionValue }}</option>
                        @endforeach
                      @endif
                    </select>
                @endif
              </div>
            @endif
          @endforeach
        </div>
        <div class="flex justify-end space-x-4 mt-4">
          <button type="button" wire:click="cancelRecord"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
            {{ __('Cancel') }}
          </button>
          <button type="submit"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
            {{ __('Save') }}
          </button>
        </div>
      </fieldset>
    </form>
  @endif
</div>

<?php // resources/views/livewire/posts/posts.blade.php

use App\Models\Post\Post as Data;
use App\Models\Backend\Category as Data1;
use Livewire\Volt\Component;

new class extends Component {
    public $fields = [
        'id' => [
            'table' => ['title' => 'Id', 'sortable' => true, 'visible' => true, 'type' => 'text'],
            'form' => [
                'title' => 'Id',
                'type' => 'text',
                'visible' => false,
                'disabled' => true,
                'visibility' => [
                    'create' => false,
                    'read' => true,
                    'update' => false,
                    'delete' => true,
                ],
            ],
            'rule' => [], // Sin reglas para el ID
        ],
        'title' => [
            'table' => ['title' => 'Title', 'sortable' => true, 'visible' => true, 'type' => 'text'],
            'form' => [
                'title' => 'Title',
                'type' => 'text',
                'visible' => true,
                'placeholder' => 'Ingrese el título',
                'visibility' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true,
                ],
            ],
            'rule' => ['required|string|min:3|max:55'],
            'message' => [
                'required' => 'El campo título es obligatorio.',
                'min' => 'El título debe tener al menos 3 caracteres.',
                'max' => 'El título no debe exceder los 55 caracteres.',
            ],
            'attribute' => 'título',
        ],
        'content' => [
            'table' => ['title' => 'Content', 'sortable' => false, 'visible' => true, 'type' => 'text'],
            'form' => [
                'title' => 'Content',
                'type' => 'textarea',
                'visible' => true,
                'placeholder' => 'Ingrese el contenido',
                'visibility' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => false,
                ],
            ],
            'rule' => ['required|string|min:10'],
            'message' => [
                'required' => 'El campo contenido es obligatorio.',
                'min' => 'El contenido debe tener al menos 10 caracteres.',
            ],
            'attribute' => 'contenido',
        ],
        'category_id' => [
            'table' => ['title' => 'Category', 'sortable' => true, 'visible' => true, 'type' => 'select'],
            'form' => [
                'title' => 'Category',
                'type' => 'select',
                'visible' => true,
                'placeholder' => 'Seleccione una categoría',
                'visibility' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => false,
                ],
            ],
            'rule' => ['required|integer|min:1'],
            'message' => [
                'required' => 'Debe seleccionar una categoría.',
                'integer' => 'La categoría debe ser un número válido.',
                'min' => 'La categoría seleccionada no es válida.',
            ],
            'attribute' => 'categoría',
        ],
        'state' => [
            'table' => ['title' => 'Status', 'sortable' => true, 'visible' => true, 'type' => 'boolean'],
            'form' => [
                'title' => 'Status',
                'type' => 'select',
                'visible' => true,
                'placeholder' => '',
                'visibility' => [
                    'create' => false,
                    'read' => true,
                    'update' => true,
                    'delete' => false,
                ],
            ],
            'rule' => ['required|boolean'],
            'message' => [
                'required' => 'El estado es obligatorio.',
                'boolean' => 'El estado debe ser un valor booleano.',
            ],
            'attribute' => 'estado',
        ],
        'user_id' => [
            'table' => ['title' => 'User', 'sortable' => true, 'visible' => true, 'type' => 'text'],
            'form' => [
                'title' => 'User',
                'type' => 'text',
                'visible' => false,
                'disabled' => true,
                'visibility' => [
                    'create' => false,
                    'read' => true,
                    'update' => false,
                    'delete' => true,
                ],
            ],
            'rule' => [], // Sin reglas para user_id (asignado automáticamente)
        ],
        'is_active' => [
            'table' => ['title' => 'Active', 'sortable' => true, 'visible' => true, 'type' => 'boolean'],
            'form' => [
                'title' => 'Active',
                'type' => 'select',
                'visible' => true,
                'placeholder' => '',
                'visibility' => [
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => false,
                ],
            ],
            'rule' => ['required|boolean'],
            'message' => [
                'required' => 'El campo activo es obligatorio.',
                'boolean' => 'El campo activo debe ser un valor booleano.',
            ],
            'attribute' => 'activo',
        ],
        'created_at' => [
            'table' => ['title' => 'Created At', 'sortable' => true, 'visible' => true, 'type' => 'date'],
            'form' => [
                'title' => 'Created At',
                'type' => 'date',
                'visible' => false,
                'disabled' => true,
                'visibility' => [
                    'create' => false,
                    'read' => true,
                    'update' => false,
                    'delete' => true,
                ],
            ],
            'rule' => [], // Sin reglas para created_at (se genera automáticamente)
        ],
    ];

    public $crudl = 'list'; // create, read, update, delete, list
    public $model = Data::class;
    public $model1 = Data1::class;

    public $tables, $forms, $rules, $messages, $validationAttributes;
    public $datas = [];
    public $categorias = [];
    public $selectedCategories = []; // Opciones seleccionadas
    protected $listeners = ['selected-updated' => 'handleSelectedUpdated'];
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $formData = [];
    public $headerClass = 'px-6 py-3 border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 text-left text-xs font-semibold tracking-wide';

    // Método para manejar las opciones seleccionadas
    public function handleSelectedUpdated($selected)
    {
        $this->selectedCategories = $selected;
    }

    public function mount()
    {
        // Obtener las categorías desde la base de datos
        $this->categorias = $this->model1::pluck('name', 'id')->toArray();

        // Extraer los subarreglos "table" y "form" sin filtrar
        $this->tables = array_combine(
            array_keys($this->fields),
            array_map(function ($field) {
                return $field['table'];
            }, $this->fields),
        );

        $this->forms = array_combine(
            array_keys($this->fields),
            array_map(function ($field) {
                return $field['form'];
            }, $this->fields),
        );

        // Cargar los datos iniciales
        $this->getData();

        // Inicializar formData con valores predeterminados
        foreach ($this->fields as $key => $field) {
            $this->formData[$key] = $field['form']['default'] ?? null;
        }

        // Asignar el ID del usuario autenticado al campo `user_id`
        if (auth()->check()) {
            $this->formData['user_id'] = auth()->user()->id;
        }
    }

    public function getData()
    {
        // Cargar las relaciones 'category' y 'user' junto con los posts
        $this->datas = $this->model
            ::with(['category', 'user'])
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
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

    public function addRecord()
    {
        $this->crudl = 'create';
    }

    public function saveRecord()
    {
        // Validar los datos del formulario usando las propiedades definidas
        $validated = $this->validate($this->rules, $this->messages, $this->validationAttributes);

        // Crear o actualizar el registro
        $this->model::updateOrCreate(
            ['id' => $this->formData['id'] ?? null], // Buscar por ID (si existe)
            $validated, // Datos a guardar
        );

        // Volver al listado
        $this->crudl = 'list';
        $this->getData();
    }

    public function cancelRecord()
    {
        $this->crudl = 'list';
    }

    public function editRecord($id)
    {
        $this->formData = $this->model::find($id)->toArray();
        $this->crudl = 'update';
    }

    public function showRecord($id)
    {
        $this->formData = $this->model::find($id)->toArray();
        $this->crudl = 'read';
    }

    public function deleteRecord($id)
    {
        $this->formData = $this->model::find($id)->toArray();
        $this->crudl = 'delete';
    }

    public function confirmDelete()
    {
        $this->model::find($this->formData['id'])->delete();
        $this->crudl = 'list';
        $this->getData();
    }
};
?>

<div>
  <div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('Posts') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Crud') }}</flux:subheading>
    <flux:separator variant="subtle" />
    @if ($crudl === 'list')
      <!-- Tabla de listado -->
      <div class="overflow-x-auto">
        <div class="pb-2">
          <button wire:click="addRecord()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Agregar Registro
          </button>
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
                      <span>
                        {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                      </span>
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
                  @foreach ($tables as $key => $table)
                    @if ($table['visible'])
                      <td class="border-none px-4 py-1 text-gray-900 dark:text-white">
                        @if ($key === 'category_id')
                          {{ $data->category->name ?? __('no exist') }}
                        @elseif ($key === 'user_id')
                          {{ $data->User->name }}
                        @elseif ($key === 'is_active')
                          {{ $data->is_active ? 'yes' : 'no' }}
                        @elseif ($key === 'created_at')
                          {{ date('d/m/Y', strtotime($data->created_at)) }}
                        @else
                          {{ $data->$key }}
                        @endif
                      </td>
                    @endif
                  @endforeach
                  <td class="border-none px-4 py-1 text-center text-gray-900 dark:text-white">
                    <button wire:click="editRecord({{ $data->id }})"
                      class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                      {{ __('Edit') }}
                    </button>
                    <button wire:click="showRecord({{ $data->id }})"
                      class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                      {{ __('Read') }}
                    </button>
                    <button wire:click="deleteRecord({{ $data->id }})"
                      class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
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
        <div class="space-y-4">
          @foreach ($forms as $key => $form)
            @if ($form['visibility'][$crudl] ?? false)
              <div>
                <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  {{ __($form['title']) }}
                </label>
                @if ($form['type'] === 'text' || $form['type'] === 'date')
                  <input type="{{ $form['type'] }}" id="{{ $key }}"
                    wire:model="formData.{{ $key }}" placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    {{ isset($form['disabled']) && $form['disabled'] ? 'disabled' : '' }}
                    readonly="{{ $crudl === 'delete' || $crudl === 'read' ? 'readonly' : '' }}">
                @elseif ($form['type'] === 'textarea')
                  <textarea id="{{ $key }}" wire:model="formData.{{ $key }}"
                    placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    readonly="{{ $crudl === 'delete' || $crudl === 'read' ? 'readonly' : '' }}"></textarea>
                @elseif ($form['type'] === 'select')
                  <select id="{{ $key }}" wire:model="formData.{{ $key }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    readonly="{{ $crudl === 'delete' || $crudl === 'read' ? 'readonly' : '' }}">
                    <option value="">{{ __($form['placeholder'] ?? '-- Seleccione --') }}</option>
                    @if ($key === 'category_id')
                      @foreach ($categorias as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                      @endforeach
                    @endif
                  </select>
                @endif
              </div>
            @endif
          @endforeach
          {{-- @foreach ($forms as $key => $form)
            @if ($form['visibility'][$crudl] ?? false)
              <div>
                <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  {{ __($form['title']) }}
                </label>
                @if ($form['type'] === 'text' || $form['type'] === 'date')
                  <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="{{ $formData[$key] }}"
                    placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    {{ isset($form['disabled']) && $form['disabled'] ? 'disabled' : '' }}
                    readonly="{{ $crudl === 'delete' || $crudl === 'read' ? 'readonly' : '' }}">
                @elseif ($form['type'] === 'textarea')
                  <textarea id="{{ $key }}" wire:model="{{ $key }}"
                    placeholder="{{ __($form['placeholder'] ?? '') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    readonly="{{ $crudl === 'delete' || $crudl === 'read' ? 'readonly' : '' }}"></textarea>
                @elseif ($form['type'] === 'select')
                  <select id="{{ $key }}" wire:model="{{ $key }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    readonly="{{ $crudl === 'delete' || $crudl === 'read' ? 'readonly' : '' }}">
                    <option value="">{{ __($form['placeholder'] ?? '-- Seleccione --') }}</option>
                    @if ($key === 'category_id')
                      @foreach ($categorias as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                      @endforeach
                    @endif
                  </select>
                @endif
              </div>
            @endif
          @endforeach --}}
          <div class="flex justify-end space-x-4">
            <button type="button" wire:click="cancelRecord"
              class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
              {{ __('Cancel') }}
            </button>
            @if ($crudl !== 'delete' && $crudl !== 'read')
              <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ $crudl === 'create' ? __('Save') : __('Update') }}
              </button>
            @endif
            @if ($crudl === 'delete')
              <button type="button" wire:click="confirmDelete"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Confirm Delete') }}
              </button>
            @endif
          </div>
        </div>
      </form>
    @endif
  </div>
</div>

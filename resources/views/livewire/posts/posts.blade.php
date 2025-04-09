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
    public $fields, $tables, $forms;
    public $rules, $messages, $valAttributes;
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

    // busqueda de contenido en la tabla
    public $search = '';
    // protected $listeners = ['search-triggered' => 'filtreSearch'];

    public $searchable = [];
    // public $filtrable = [];

    public $perPage = 10; // Número de registros mostrados por lote
    public $perPageArray = [5, 10, 25, 50, 'all'];
    public $loadedRecords = 0; // Registros cargados hasta el momento

    public $formData = [];
    public $subTitle = 'List Records';
    public $headerClass = 'px-6 py-3 border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 text-left text-xs font-semibold tracking-wide';
    public $classInput = 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm';

    public function mount()
    {
        // Cargar los campos desde la configuración
        // $this->fields = config('camposPost');
        $this->fields = [
            'id' => [
                'table' => ['title' => 'Id', 'sortable' => true, 'visible' => true, 'type' => 'integer'],
                'form' => [
                    'title' => 'Id',
                    'type' => 'text',
                    'disabled' => true,
                    'visibility' => [
                        'create' => false,
                        'read' => true,
                        'update' => false,
                        'delete' => true,
                    ],
                    'default' => null,
                ],
                'validation' => [],
                'searchable' => true,
                'filtrable' => false,
            ],
            'title' => [
                'table' => ['title' => 'Title', 'sortable' => true, 'visible' => true, 'type' => 'text'],
                'form' => [
                    'title' => 'Title',
                    'type' => 'text',
                    'placeholder' => 'Ingrese el título',
                    'visibility' => [
                        'create' => true,
                        'read' => true,
                        'update' => true,
                        'delete' => true,
                    ],
                    'default' => '',
                ],
                'validation' => [
                    'rule' => ['required', 'string', 'min:3', 'max:55'],
                    'message' => [
                        'required' => 'El campo :attibute es obligatorio.',
                        'min' => 'El :attibute debe tener al menos 3 caracteres.',
                        'max' => 'El :attibute no debe exceder los 55 caracteres.',
                    ],
                    'attribute' => 'título',
                ],
                'searchable' => true,
            ],
            'content' => [
                'table' => ['title' => 'Content', 'sortable' => false, 'visible' => true, 'type' => 'text'],
                'form' => [
                    'title' => 'Content',
                    'type' => 'textarea',
                    'placeholder' => 'Ingrese el contenido',
                    'visibility' => [
                        'create' => true,
                        'read' => true,
                        'update' => true,
                        'delete' => true,
                    ],
                ],
                'validation' => [
                    'rule' => ['required', 'string', 'min:10'],
                    'message' => [
                        'required' => 'El campo contenido es obligatorio.',
                        'min' => 'El contenido debe tener al menos 10 caracteres.',
                    ],
                    'attribute' => 'contenido',
                ],
                'searchable' => true,
            ],
            'category_id' => [
                'table' => ['title' => 'Category', 'sortable' => true, 'visible' => true, 'type' => 'select', 'model' => 'model1'],
                'form' => [
                    'title' => 'Category',
                    'type' => 'select',
                    'placeholder' => 'Seleccione una categoría',
                    'visibility' => [
                        'create' => true,
                        'read' => true,
                        'update' => true,
                        'delete' => true,
                    ],
                ],
                'validation' => [
                    'rule' => ['required', 'integer', 'min:1'],
                    'message' => [
                        'required' => 'Debe seleccionar una categoría.',
                        'integer' => 'La categoría debe ser un número válido.',
                        'min' => 'La categoría seleccionada no es válida.',
                    ],
                    'attribute' => 'categoría',
                ],
                'searchable' => false,
                'filtrable' => true,
            ],
            'user_id' => [
                'table' => ['title' => 'User', 'sortable' => true, 'visible' => true, 'type' => 'select', 'model' => 'model2'],
                'form' => [
                    'title' => 'User',
                    'type' => 'text',
                    'disabled' => true,
                    'visibility' => [
                        'create' => false,
                        'read' => true,
                        'update' => false,
                        'delete' => true,
                    ],
                ],
                'validation' => [], // Sin reglas para user_id (asignado automáticamente)
                'searchable' => false,
                'filtrable' => true,
            ],
            'slug' => [
                'table' => [
                    'title' => 'Slug',
                    'sortable' => true,
                    'visible' => false,
                    'type' => 'text',
                ],
                'form' => [
                    'title' => 'Slug',
                    'type' => 'text',
                    'placeholder' => 'Slug generado automáticamente',
                    'disabled' => true,
                    'visibility' => [
                        'create' => false,
                        'read' => true,
                        'update' => false,
                        'delete' => false,
                    ],
                ],
                'validation' => [
                    'rule' => ['required', 'string'],
                    'message' => [
                        'required' => 'El campo slug es obligatorio.',
                    ],
                    'attribute' => 'slug',
                ],
            ],
            'image_path' => [
                'table' => [
                    'title' => 'Image',
                    'sortable' => false,
                    'type' => 'image',
                    'visible' => false,
                ],
                'form' => [
                    'title' => 'Image',
                    'type' => 'file',
                    'disabled' => false,
                    'visibility' => [
                        'create' => true,
                        'read' => true,
                        'update' => true,
                        'delete' => true,
                    ],
                ],
                'validation' => [
                    'rule' => ['nullable', 'image', 'max:2048'], // Máximo 2MB
            'message' => [
                'image' => 'El archivo debe ser una imagen válida.',
                'max' => 'La imagen no debe exceder los 2MB.',
            ],
                    'attribute' => 'foto',
                ],
                'searchable' => false,
            ],
            'state' => [
                'table' => ['title' => 'Status', 'sortable' => true, 'visible' => true, 'type' => 'text'],
                'form' => [
                    'title' => 'Status',
                    'type' => 'selectWithOptions',
                    'placeholder' => '',
                    'visibility' => [
                        'create' => true,
                        'read' => true,
                        'update' => true,
                        'delete' => true,
                    ],
                    'options' => ['draft' => 'Draft', 'new' => 'New', 'editing' => 'Editing', 'published' => 'Published', 'archived' => 'Archived'],
                ],
                'validation' => [
                    'rule' => ['required', 'in:draft,new,editing,published,archived'],
                    'message' => [
                        'required' => 'El estado es obligatorio.',
                        'in' => 'El estado debe ser uno de los valores permitidos.',
                    ],
                    'attribute' => 'estado',
                ],
                'searchable' => false,
                'filtrable' => true,
            ],
            'is_active' => [
                'table' => ['title' => 'Active', 'sortable' => true, 'visible' => true, 'type' => 'boolean'],
                'form' => [
                    'title' => 'Active',
                    'type' => 'select',
                    'placeholder' => '',
                    'visibility' => [
                        'create' => true,
                        'read' => true,
                        'update' => true,
                        'delete' => true,
                    ],
                ],
                'validation' => [
                    'rule' => ['required', 'boolean'],
                    'message' => [
                        'required' => 'El campo activo es obligatorio.',
                        'boolean' => 'El campo activo debe ser un valor booleano.',
                    ],
                    'attribute' => 'activo',
                ],
                'searchable' => false,
            ],
            'created_at' => [
                'table' => ['title' => 'Created At', 'sortable' => true, 'visible' => true, 'type' => 'date'],
                'form' => [
                    'title' => 'Created At',
                    'type' => 'date',
                    'disabled' => true,
                    'visibility' => [
                        'create' => false,
                        'read' => true,
                        'update' => true,
                        'delete' => true,
                    ],
                ],
                'validation' => [], // Sin reglas para created_at (se genera automáticamente)
                'searchable' => true,
            ],
        ];
        if (empty($this->fields)) {
            throw new \Exception("Los campos no están configurados correctamente en 'config/camposPost'.");
        }

        // Obtener las categorías desde la base de datos
        $this->categorias = $this->model1::pluck('name', 'id')->toArray();

        // Extraer los subarreglos "table" y "form"
        // DATOS PARA TABLAS
        $this->tables = array_combine(
            array_keys($this->fields),
            array_map(function ($field) {
                return $field['table'] + ['visible' => $field['table']['visible'] ?? false]; // Asegurar la clave 'visible'
            }, $this->fields),
        );
        // DATOS PARA FORMULARIOS
        $this->forms = array_combine(
            array_keys($this->fields),
            array_map(function ($field) {
                return $field['form'];
            }, $this->fields),
        );
        // RECORRE TODOS LOS CAMPOS para inicializar valores y extraer reglas de validación
        foreach ($this->fields as $key => $field) {
            // Inicializar form con valores predeterminados
            $this->formData[$key] = $field['form']['default'] ?? null;
            if ($key === 'is_active') {
                $this->is_Active = true;
            }
            // campos que se pueden buscar
            // if ($field['form']['searchable']) {
            //     $this->searchable = $key;
            // }
            // Inicializar reglas, mensajes y atributos de validación
            // DATOS REGLAS DE VALIDACION
            // Verificar si el campo tiene una clave 'validation'
            if (isset($field['validation'])) {
                // Inicializar reglas
                $this->rules[$key] = $field['validation']['rule'] ?? [];

                // Inicializar mensajes personalizados
                if (isset($field['validation']['message'])) {
                    foreach ($field['validation']['message'] as $rule => $message) {
                        $this->messages["$key.$rule"] = $message;
                    }
                }

                // Inicializar atributos personalizados
                if (isset($field['validation']['attribute'])) {
                    $this->valAttributes[$key] = $field['validation']['attribute'];
                }
            } else {
                // Si no hay validación definida, inicializar con valores vacíos
                $this->rules[$key] = [];
                $this->messages[$key] = [];
                $this->valAttributes[$key] = '';
            }
        }

        $this->searchable = collect($this->fields)->filter(fn($field) => isset($field['searchable']) && $field['searchable'] === true)->keys()->toArray();
        // dd($this->searchable);

        $this->filtrable = collect($this->fields)->filter(fn($field) => isset($field['filtrable']) && $field['filtrable'] === true)->keys()->toArray();
        // dd($this->filtrable);

        // Asignar el ID del usuario autenticado al campo `user_id`
        if (auth()->check()) {
            $this->formData['user_id'] = auth()->user()->id;
        }

        // Cargar los datos iniciales
        $this->getData();
    }

    /**
     * Método para cargar los datos de la base de datos
     * y aplicar filtros y ordenamiento.
     */
    public function getData()
    {
        $query = $this->model::with(['category', 'user']);

        if ($this->activeFilter !== '') {
            $query->where('is_active', $this->activeFilter);
        }
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                foreach ($this->searchable as $field) {
                    $q->orWhere($field, 'like', $searchTerm);
                }
            });
        }

        // Aplicar paginación
        $this->datas = $query->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage); // registros por página
    }

    public function filtreSearch(): void
    {
        $this->getData();
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
            dd(['valores' => $this->formData, 'rules' => $this->rules, 'messages' => $this->messages, 'Attributes' => $this->valAttributes]);
            $validated = $this->validate($this->rules, $this->messages, $this->valAttributes);

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
                $validated['image_path'] = 'images/posts/' .$imageName;
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

        <div>
          <input type="search" id="search" wire:model.live="search" placeholder="{{ __('Search') }}"
            wire:keydown.debounce.500ms="filtreSearch"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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
                  class="{{ $headerClass }} cursor-pointer border-r border-gray-300 last:border-r-0 {{ $table['sortable'] ? 'uppercase' : 'capitalize' }}"
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
              <tr
                class="{{ $data->id % 2 === 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-900' }}bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                {{-- @include('partials.formatTable', ['data' => $data, 'tables' => $tables]) --}}
                {{-- resources/views/partials/formatTable.blade.php --}}

                @foreach ($tables as $campoNombre => $campoInfo)
                  @php
                    // Obtener el valor del campo actual
                    $valorCampo = $data->$campoNombre ?? null;

                    // Obtener el tipo de campo desde el arreglo $table
                    $tipoCampo = $campoInfo['type'] ?? 'text';

                    // Verificar si el campo es visible en la tabla
                    $visible = isset($campoInfo['visible']) && $campoInfo['visible'];
                  @endphp

                  @if ($visible)
                    <td class="border-none px-4 py-1 text-gray-900 dark:text-white">
                      @switch($tipoCampo)
                        @case('integer')
                          <div class="text-right">
                            {{ $valorCampo }}
                          </div>
                        @break

                        @case('decimal')
                          <div class="text-right">
                            {{ number_format($valorCampo, $campoInfo['decimal'] ?? 2, '.', ',') }}
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

                        @case('selectWithModel')
                          <div class="text-center">
                            @php
                              $modelName = $campoInfo['model'] ?? null;
                              $relatedData = null;

                              if ($modelName) {
                                  $model = app('App\\Models\\' . $modelName);
                                  if (isset($data->{$campoNombre}) && !$data->{$campoNombre}->isEmpty()) {
                                      $relatedData = $data->{$campoNombre};
                                  }
                              }
                            @endphp
                            @if ($relatedData)
                              @foreach ($relatedData as $item)
                                <span>{{ $item->name }}</span>
                                @if (!$loop->last)
                                  -
                                @endif
                              @endforeach
                            @else
                              No existen datos relacionados
                            @endif
                          </div>
                        @break

                        @case('selectWithOptions')
                          <div class="text-center">
                            @php
                              $options = $campoInfo['options'] ?? [];
                              $selectedValue = $valorCampo ?? null;
                              $selectedText = '';

                              foreach ($options as $key => $value) {
                                  if ($key == $selectedValue) {
                                      $selectedText = $value;
                                      break;
                                  }
                              }
                            @endphp
                            <span>{{ $selectedText ?: '-' }}</span>
                          </div>
                        @break

                        @case('image')
                          <div class="h-10 w-10 text-center">
                             @php
            // Verificar si el campo es una relación (por ejemplo, user.profile_photo_path)
            $isRelation = strpos($campoNombre, '.') !== false;
            $imagePath = $isRelation
                ? data_get($data, $campoNombre) // Obtener el valor de la relación
                : $valorCampo; // Usar el valor directo del campo
        @endphp
                            @if ($imagePath && Storage::disk('public')->exists($imagePath))
                              <img alt="Foto" src="{{ asset('storage/' . $imagePath) }}" class="rounded-full h-10 w-10 object-cover" onerror="this.src='{{ asset('images/default.png') }}'">
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

                <td class="border-none px-4 py-1 text-center text-gray-900 dark:text-white">
                  <div
                    class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <button wire:click="editRecord({{ $data->id }})"
                      class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer flex items-center justify-center">
                      <x-forms.icons name="globe" class="w-5 h-5 text-white mr-2 sm:mr-0" />
                      <span class="hidden sm:inline">{{ __('Edit') }}</span>
                    </button>
                    <button wire:click="showRecord({{ $data->id }})"
                      class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded cursor-pointer flex items-center justify-center">
                      <x-forms.icons name="arrow-up" class="w-5 h-5 text-white mr-2 sm:mr-0" />
                      <span class="hidden sm:inline">{{ __('Read') }}</span>
                    </button>
                    <button wire:click="deleteRecord({{ $data->id }})"
                      class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer flex items-center justify-center">
                      <x-forms.icons name="arrow-down" class="w-5 h-5 text-white mr-2 sm:mr-0" />
                      <span class="hidden sm:inline">{{ __('Delete') }}</span>
                    </button>
                  </div>
                </td>
    </div>
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
  <!-- Enlaces de paginación -->
  <div class="mt-4 flex justify-between items-center border-t-2 border-gray-200 dark:border-gray-500">
    <div>
      <select id="perPage" wire:model="perPage" class="border border-gray-300 rounded-md px-2 py-1">
        @foreach ($perPageArray as $per)
        <option value="{{ $per }}">{{ $per }}</option>
        @endforeach
        </select>
    </div>
    <div>{{ $datas->links() }}</div>
  </div>
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
              <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="formData.{{ $key }}"
                placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
              {{-- NUMBER --}}
            @elseif ($form['type'] === 'number')
              <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="formData.{{ $key }}"
                placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
              {{-- EMAIL --}}
            @elseif ($form['type'] === 'email')
              <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="formData.{{ $key }}"
                placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
              {{-- PASSWORD --}}
            @elseif ($form['type'] === 'password')
              <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="formData.{{ $key }}"
                placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
              {{-- CHECKBOX --}}
            @elseif ($form['type'] === 'checkbox')
              <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="formData.{{ $key }}"
                placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
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
              <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="formData.{{ $key }}"
                placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
              {{-- DATETIME --}}
            @elseif ($form['type'] === 'datetime')
              <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="formData.{{ $key }}"
                placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
              {{-- TIME --}}
            @elseif ($form['type'] === 'time')
              <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="formData.{{ $key }}"
                placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
              {{-- COLOR --}}
            @elseif ($form['type'] === 'color')
              <input type="{{ $form['type'] }}" id="{{ $key }}" wire:model="formData.{{ $key }}"
                placeholder="{{ __($form['placeholder'] ?? '') }}" class="{{ $classInput }}"
                {{ $form['disabled'] ?? false ? 'disabled' : '' }}>
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

<?php

use Livewire\Volt\Component;
use App\models\post\Post as Data;
use App\models\backend\Category as Data1;
use App\models\backend\Tag as Data2;
use App\models\User as Data3;
// use Livewire\WithPagination;

new class extends Component {
    // use WithPagination;

    // campos a reemplazar en las tablas
    public $post_id,
        $titulo,
        $content,
        $category_id = ' ',
        $user_id,
        $image_path,
        $state,
        $is_active;
    public $selectedTags = [];

    public string $search = '';
    #[Locked]
    public string $sortField = 'id';

    #[Url]
    public string $sortDirection = 'DESC';
    private array $sortableFields = ['id', 'titulo', 'email', 'state', 'created_at'];

    public $crudl = 'create';

    public $posts, $categories, $tags;
    public $model = Data::class;

    public function mount()
    {
        $this->cleanFields();
        $this->categories = Data1::orderBy('id')->pluck('name', 'id');
        $this->tags = Data2::orderBy('id')->pluck('name', 'id');
        // dd(['categories'=>$this->categories, 'tags'=>$this->tags]);

        // $query = $this->model::with(['category', 'user']);

        // $this->posts = Data::get(['titulo', 'content', 'category_id', 'user_id', 'image_path', 'state', 'is_active', 'created_at']);
        $this->posts = Data::all();
        // dd($this->posts);
        $this->crudl = 'list';
    }

    public function getData()
    {
        $query = $this->model
            ::with(['category', 'user'])
            ->when($this->search, function ($query) {
                $query->where('titulo', 'like', '%' . $this->search . '%')->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection);

        // dd($query);
        return $query;
    }

    public function sortBy(string $sortField)
    {
        if (!in_array($sortField, $this->sortableFields)) {
            return;
        }
        if ($sortField === $this->sortField) {
            $this->sortDirection = $this->sortDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->sortDirection = 'ASC';
            $this->sortField = $sortField;
        }
    }

    public function save()
    {
        // dd(['titulo' => $this->titulo, 'content' => $this->content, 'category_id' => $this->category_id, 'user_id' => $this->user_id, 'image_path' => $this->image_path, 'state' => $this->state, 'is_active' => $this->is_active, 'tags' => $this->selectedTags]);
        $rules = [
            'titulo' => 'required|string|max:100|unique:posts,titulo,' . $this->post_id,
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'nullable|image|max:2048',
            'state' => 'in:draft,new,editing,published,archived,deleted',
            'is_active' => 'boolean',
            'selectedTags' => 'array',
        ];

        // Add user_id validation based on create/edit mode
        if ($this->crudl === 'create') {
            $rules['user_id'] = 'required|exists:users,id';
        } else {
            // For edit mode, verify the user exists but exclude the current post's user
            $rules['user_id'] = [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if (auth()->id() !== $value && !auth()->user()->isAdmin()) {
                        $fail('You are not authorized to change the post owner.');
                    }
                },
            ];
        }

        dd('pausa');
        $validated = $this->validate($rules);
        $post = Data::updateOrCreate(
            ['id' => $this->posts_id ?? null],
            [
                'titulo' => $validated['titulo'],
                'slug' => Str::slug($this->titulo),
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'user_id' => $validated['user_id'],
                'image_path' => $validated['image_path'],
                'state' => $validated['state'],
                'is_active' => $validated['is_active'],
            ],
        );

        $post->tags()->sync(
            collect($validated['selectedTags'])->mapWithKeys(function ($tagId) {
                return [
                    $tagId => [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ];
            }),
        );

        $this->cleanFields();
        $this->crudl = 'list';
        session()->flash('success', __('Post created successfully'));
    }

    public function cleanFields()
    {
        // $this->reset(['titulo', 'content', 'category_id', 'user_id', 'image_path', 'state', 'is_active', 'selectedTags']);

        $this->post_id = null;
        $this->titulo = '';
        $this->content = '';
        $this->category_id = '';
        $this->selectedTags = [];
        // Asignar el ID del usuario autenticado al campo `user_id`
        $this->user_id = auth()->check() ? auth()->user()->id : 0;
        $this->image_path = '';
        $this->state = 'new';
        $this->is_active = true;
    }
    public function fillFields($id)
    {
        $this->posts = Data::find($id);
        $post_id = $this->post_id;
        $this->titulo = $this->posts->titulo;
        $this->content = $this->posts->content;
        $this->category_id = $this->posts->category_id;
        $this->selectedTags = $this->posts->tags()->pluck('id')->toArray();
        $this->image_path = $this->posts->image_path;
        $this->state = $this->posts->state;
        $this->is_active = $this->posts->is_active;
        // Asignar el ID del usuario autenticado al campo `user_id`
        $this->user_id = $this->posts->user_id;
        if (auth()->user()->id !== $this->posts->user_id && auth()->user()->role !== 'admin') {
            session()->flash('error', __('you are not authorized to edit this post'));
            $this->crudl = 'read';
        }
    }
};
?>

<div>
  @if ($crudl === 'list')
    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Rechercher un utilisateur" />
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>Title</th>
          <th>Content</th>
          <th>Category</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($posts as $post)
          <tr wire:key="{{ $post->id }}">
            <td>{{ $post->id }}</td>
            <td>{{ $post->titulo }}</td>
            <td>{{ substr($post->content, 0, 15) }}...</td>
            <td>{{ $post->category->name }}</td>
            <td>{{ $post->is_active ? 'yes' : '-' }}</td>
            <td>
              <button wire:click="edit({{ $post->id }})">Edit</button>
              <button wire:click="read({{ $post->id }})">Read</button>
              <button wire:click="delete({{ $post->id }})">Delete</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{-- {{ $posts->links() }} --}}
  @elseif($crudl === 'create')
    <form wire:submit.prevent="save">
      <div class="mb-4">
        <x-label for="name" class="text-gray-700 ml-4">{{ __('Title') }}</x-label>
        <x-input wire:model="titulo" required placeholder="{{ __('Title') }}" class="w-full" />
      </div>
      <div class="mb-4">
        <x-label for="content" class="text-gray-700 ml-4">{{ __('Content') }}</x-label>
        <x-textarea wire:model="content" required placeholder="{{ __('Content') }}" class="w-full" />
      </div>

      <div class="mb-4">
        <x-label for="category_id" class="text-gray-700">{{ __('Category') }}</x-label>
        <x-select wire:model="category_id" class="w-full">
          <option value="" disabled>{{ __('Select...') }}</option>
          @foreach ($categories as $id => $categorie)
            <option value="{{ $id }}">{{ $categorie }}</option>
          @endforeach
        </x-select>
      </div>

      <div class="mb-4">
        <x-label class="text-gray-700">{{ __('Tags') }}</x-label>
        <ul>
          @foreach ($tags as $id => $tag)
            <li>
              <label class="flex items-center">
                <x-checkbox wire:model="selectedTags" value="{{ $id }}" />
                <span class="ml-8 text-gray-700">{{ $tag }}</span>
              </label>
            </li>
          @endforeach
        </ul>
      </div>

      {{-- <div class="mb-4">
        <x-label for="active" class="text-gray-700">active</x-label>
        <x-input type="checkbox" id="is_active" wire:model="is_active" placeholder="Active" class="w-1/8" />
      </div> --}}

      <div class="mb-4 flex">
        <div class="">

          <button
            class=" bg-inherit text-gray-600 hover:bg-gray-600 hover:text-gray-100 border rounded-full px-4 py-2">Cancel</button>
          <button type="submit"
            class="justify-end bg-blue-500 text-gray-100  hover:bg-blue-100 hover:text-blue-500 border rounded-full px-4 py-2">Créer</button>
        </div>
      </div>
    </form>
  @endif
</div>

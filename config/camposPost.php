<?php

return [
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
        ],
        'rule' => [], // Sin reglas para el ID
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
        ],
        'rule' => ['required', 'string', 'min:3', 'max:55'],
        'message' => [
            'required' => 'El campo :attibute es obligatorio.',
            'min' => 'El :attibute debe tener al menos 3 caracteres.',
            'max' => 'El :attibute no debe exceder los 55 caracteres.',
        ],
        'attribute' => 'título',
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
        'rule' => ['required', 'string', 'min:10'],
        'message' => [
            'required' => 'El campo contenido es obligatorio.',
            'min' => 'El contenido debe tener al menos 10 caracteres.',
        ],
        'attribute' => 'contenido',
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
        'rule' => ['required', 'integer', 'min:1'],
        'message' => [
            'required' => 'Debe seleccionar una categoría.',
            'integer' => 'La categoría debe ser un número válido.',
            'min' => 'La categoría seleccionada no es válida.',
        ],
        'attribute' => 'categoría',
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
        'rule' => [], // Sin reglas para user_id (asignado automáticamente)
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
        'rule' => ['required', 'string'],
        'message' => [
            'required' => 'El campo slug es obligatorio.',
        ],
        'attribute' => 'slug',
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
        'rule' => ['nullable', 'string'],
        'message' => [
            'string' => 'El campo :attribute debe ser una cadena de texto.',
        ],
        'attribute' => 'path',
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
        'rule' => ['required', 'in:draft,new,editing,published,archived'],
        'message' => [
            'required' => 'El estado es obligatorio.',
            'in' => 'El estado debe ser uno de los valores permitidos.',
        ],
        'attribute' => 'estado',
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
        'rule' => ['required', 'boolean'],
        'message' => [
            'required' => 'El campo activo es obligatorio.',
            'boolean' => 'El campo activo debe ser un valor booleano.',
        ],
        'attribute' => 'activo',
        'search' => true, // Habilitar búsqueda en este campo

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
        'rule' => [], // Sin reglas para created_at (se genera automáticamente)
        'search' => true, // Habilitar búsqueda en este campo
    ],
];

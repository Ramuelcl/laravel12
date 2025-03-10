<?php
// config/CamposUser.php

return [
    'id' => [
        // tabla
        'titulo1' => 'Id',
        'visible1' => true,
        // input
        'titulo2' => 'Id',
        'visible2' => true,
        'disabled' => true,
        // tipo de campo
        'tipo' => 'integer',
        'decimal' => 0,
    ],

    'name' => [
        // tabla
        'titulo1' => 'Name',
        'visible1' => true,
        // input
        'titulo2' => 'Name',
        'visible2' => true,
        // tipo de campo
        'tipo' => 'string',
    ],

    'email' => [
        // tabla
        'titulo1' => 'Mail',
        'visible1' => true,
        // input
        'titulo2' => 'Mail',
        'visible2' => true,
        // tipo de campo
        'tipo' => 'mail',
    ],

    'password' => [
        // tabla
        'titulo1' => '',
        'visible1' => false,
        // input
        'titulo2' => 'Password',
        'visible2' => false,
        // tipo de campo
        'tipo' => 'password',
    ],

    'profile_photo_path' => [
        // tabla
        'titulo1' => 'Photo',
        'visible1' => true,
        // input
        'titulo2' => 'Photo',
        'visible2' => true,
        // tipo de campo
        'tipo' => 'image',
    ],

    'is_active' => [
        // tabla
        'titulo1' => 'Active',
        'visible1' => true,
        // input
        'titulo2' => 'Active',
        'visible2' => true,
        // tipo de campo
        'tipo' => 'checkbox',
    ],

    'created_at' => [
        // tabla
        'titulo1' => 'Created',
        'visible1' => true,
        // input
        'titulo2' => 'Created',
        'visible2' => false,
        // tipo de campo
        'tipo' => 'date',
    ],
];

<?php
// UserCampos.php

return [
  'id' => [
    // lista
    'titulo1' => 'Id',
    'visible1' => true,
    // ordenar solo si está visible en la lista 'visible1' => true,
    'ordenar' => true,
    // ingreso
    'titulo2' => 'Tipo',
    'visible2' => false,
    // tipo de campo
    'tipo' => 'integer',
    'decimal' => 0,
  ],

  'tipoEntidad' => [
    // lista
    'titulo1' => 'Tipo',
    'visible1' => true,
    // ordenar solo si está visible en la lista 'visible1' => true,
    'ordenar' => true,
    // ingreso
    'titulo2' => 'Tipo',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'list',
    'arreglo' => 'arrEntidad',
  ],

  'nombres' => [
    // lista
    'titulo1' => 'Nombres',
    'visible1' => true,
    // ordenar
    'ordenar' => true,
    // ingreso
    'titulo2' => 'Nombres',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'string',
  ],

  'apellidos' => [
    // lista
    'titulo1' => 'Apellidos',
    'visible1' => true,
    // ordenar
    'ordenar' => true,
    // ingreso
    'titulo2' => 'Apellidos',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'string',
  ],

  'is_active' => [
    // lista
    'titulo1' => 'Activo',
    'visible1' => true,
    // ordenar
    'ordenar' => false,
    // ingreso
    'titulo2' => 'Activo',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'checkit',
  ],

  'titulo' => [
    // lista
    'titulo1' => 'Título',
    'visible1' => false,
    'ordenar' => false,
    // ingreso
    'titulo2' => 'Título',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'string',
  ],

  'razonSocial' => [
    // lista
    'titulo1' => 'Razon Social',
    'visible1' => false,
    'ordenar' => false,
    // ingreso
    'titulo2' => 'Razon Social',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'string',
  ],

  'website' => [
    // lista
    'titulo1' => 'web',
    'visible1' => false,
    'ordenar' => false,
    // ingreso
    'titulo2' => 'Web',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'string',
  ],

  'aniversario' => [
    // lista
    'titulo1' => 'Creado',
    'visible1' => false,
    'ordenar' => false,
    // ingreso
    'titulo2' => 'Creado',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'date',
  ],

  'sexo' => [
    // lista
    'titulo1' => 'Sexo',
    'visible1' => false,
    'ordenar' => false,
    // ingreso
    'titulo2' => 'Sexo',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'date',
  ],

  'created_at' => [
    // lista
    'titulo1' => 'Inicio',
    'visible1' => false,
    'ordenar' => false,
    // ingreso
    'titulo2' => 'Inicio',
    'visible2' => true,
    // tipo de campo
    'tipo' => 'date',
  ],
];

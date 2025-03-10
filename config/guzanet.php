<?php

// config/guzanet.php
// "clave" => "valor",
return [
  "sistema" => [
    ["banca" => 1],
    ["trabajo" => 2],
    ["ventas" => 3],
    ["compras" => 4],
    ["inventario" => 5],
    ["remuneraciones" => 7],
  ],
  "appEmpresa" => "Guzanet",
  "appLogo" => "images/Guzanet.png", //public\app\logo

  "appNombre" => "Ramuel Gonzalez",
  "appMail" => "Ramuelcl@gmail.com",
  "appLargoClave" => 3,

  "idioma" => "es-ES",
  "idiomasDir" => "app/flags/",
  "idiomas" => ["es" => "Español", "en" => "English", "fr" => "Français"],
  "icon_paths" => [
    "solid" => "app/icons/solid", //public\app\icons
    "outline" => "app/icons/outline", //public\app\icons
  ],
  'themes' => [
    'light' => [
      'bg' => '#ffffff',
      'text' => '#000000',
    ],
    'dark' => [
      'bg' => '#1a202c',
      'text' => '#ffffff',
    ],
    'ocean' => [
      'bg' => '#93c5fd', // Equivalente a bg-blue-300
      'text' => '#2563eb', // Equivalente a text-blue-600
    ],
    'forest' => [
      'bg' => '#fcd34d', // Equivalente a bg-amber-300
      'text' => '#d97706', // Equivalente a text-amber-600
    ],
    'sunset' => [
      'bg' => '#fff0e6',
      'text' => '#663300',
    ],
    'midnight' => [
      'bg' => '#1a1a2e',
      'text' => '#ffffff',
    ],
    'dawn' => [
      'bg' => '#f0f0f0',
      'text' => '#000000',
    ],
    'dusk' => [
      'bg' => '#2e2e2e',
      'text' => '#ffffff',
    ],
  ],
];

/**
 *
// Acceder a un valor específico
$valor = config('nombre-del-archivo.clave');

// Acceder a todos los valores como un array asociativo
$configuracion = config('nombre-del-archivo');

// Obtener el valor actual de la configuración
$valorActual = config('nombre-del-archivo.clave');

// Modificar el valor en tiempo de ejecución
config(['nombre-del-archivo.clave' => 'nuevo_valor']);

 */

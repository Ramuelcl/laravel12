<?php
// Reglas de validación para todos los campos
    protected $rules = [
    'name' => 'required|string|min:3|max:55',
    'email' => 'required|email|max:55|unique:users',
    'password' => 'required',
    'phone' => 'required|numeric',
    'select' => 'required|integer|min:1',
    'terms' => 'required|min:1',
    'checkbox' => 'required',
    'textarea' => 'required',
    'radio' => 'required',
    'date' => 'required',
    'time' => 'required',
    'datetime' => 'required',
    'color' => 'required',
    'file' => 'required',
    'range' => 'required',
    'number' => 'required',
    'url' => 'required',
    'search' => 'required',
    ];

    // Mensajes de error personalizados
    protected $messages = [
    'name.required' => 'El campo nombre es obligatorio.',
    'name.min' => 'El nombre debe tener al menos 3 caracteres.',
    'name.max' => 'El nombre no debe exceder los 55 caracteres.',
    'phone.required' => 'El campo teléfono es obligatorio.',
    'phone.numeric' => 'El teléfono debe ser un número.',
    'email.required' => 'El campo correo electrónico es obligatorio.',
    'email.email' => 'El correo electrónico debe ser válido.',
    'email.max' => 'El correo electrónico no debe exceder los 55 caracteres.',
    'message.required' => 'El campo mensaje es obligatorio.',
    ];

    // Atributos de validación personalizados
    protected $validationAttributes = [
    'name' => 'nombre',
    'phone' => 'teléfono',
    'email' => 'correo electrónico',
    'terms' => 'términos y condiciones',
    'select' => 'opción',
    'checkbox' => 'casilla de verificación',
    'textarea' => 'área de texto',
    'radio' => 'opción',
    'date' => 'fecha',
    'time' => 'hora',
    'datetime' => 'fecha y hora',
    'color' => 'color',
    'message' => 'mensaje',
    ];
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function create()
    {
        return view('formPruebas');
    }

    // Reglas de validación para todos los campos
    protected $rules = [
        'name' => 'required|string|min:3|max:55',
        'phone' => 'required|numeric',
        'email' => 'required|email|max:55|unique:users',
        'message' => 'required',
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
        'message' => 'mensaje',
    ];

    public function store(Request $request)
    {
        // Validar los datos del formulario usando las propiedades definidas
        $validated = $request->validate($this->rules, $this->messages, $this->validationAttributes);

        // Lógica para guardar los datos (puedes agregarla aquí)

        return redirect()->back()
            ->with('success', 'Formulario enviado correctamente');
    }
}

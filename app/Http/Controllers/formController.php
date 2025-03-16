<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class formController extends Controller
{
    public function create()
    {
        return view('formPruebas');
    }

    public function store(Request $request)
    {
        dump($request->all());
        $request->validate([
            'name' => 'required|string|min:3|max:55',
            'email' => 'required|email|max:55',
            'message' => 'required',
        ]);

        return redirect()->route('formulario.create')
            ->with('message', 'Formulario enviado correctamente');
    }
}

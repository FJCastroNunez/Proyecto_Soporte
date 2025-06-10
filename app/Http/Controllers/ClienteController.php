<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = cliente::orderBy('created_at', 'desc')->get();
        return view('mantenedores.cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mantenedores.cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'tipo' => 'required|integer|in:1,2',
            'rut' => 'required',
            'nombre' => 'required|string|max:100',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        // Crear el nuevo cliente y guardar en $cliente
        $cliente = \App\Models\Cliente::create([
            'tipo' => $request->tipo,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'rut' => $request->rut,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'status' => 1, // Activo por defecto
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redireccionar con mensaje de éxito incluyendo el ID
        return redirect()->route('clientes.index')->with('success', 'Cliente registrado exitosamente con el ID: ' . $cliente->id);
    }



    /**
     * Display the specified resource.
     */
    public function show(cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = cliente::findOrFail($id);
        return view('mantenedores.cliente.update', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'tipo' => 'required|integer|in:1,2',
            'nombre' => 'required|string|max:100',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'status' => 'required|integer|in:0,1',
        ]);

        // Buscar el cliente
        $cliente = \App\Models\Cliente::findOrFail($id);

        // Actualizar los datos
        $cliente->update([
            'tipo' => $request->tipo,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->route('clientes.index', $cliente->id)
            ->with('success', 'Cliente actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cliente $cliente)
    {
        //
    }
}

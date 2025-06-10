<?php

namespace App\Http\Controllers;

use App\Models\Problema;
use Illuminate\Http\Request;

class ProblemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los problemas ordenados por fecha de creación (más recientes primero)
        $problemas = Problema::orderBy('created_at', 'desc')->get();

        // Retornar la vista con los datos
        return view('mantenedores.problema.index', compact('problemas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mantenedores.problema.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar solo el nombre, porque el status será asignado automáticamente
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        Problema::create([
            'nombre' => $request->nombre,
            'status' => 1, // Asignado por defecto como activo
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('problemas.index')->with('success', 'Problema creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Problema $problema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $problema = \App\Models\Problema::findOrFail($id);
        return view('mantenedores.problema.update', compact('problema'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los campos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'status' => 'required|integer|in:0,1',
        ]);

        // Buscar el problema por ID
        $problema = Problema::findOrFail($id);

        // Actualizar los valores
        $problema->update([
            'nombre' => $request->nombre,
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        // Redireccionar con mensaje de éxito
        return redirect()->route('problemas.index', $problema->id)
            ->with('success', 'Problema actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Problema $problema)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\perfil;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perfiles = \App\Models\Perfil::orderBy('created_at', 'desc')->get();

        return view('mantenedores.perfil.index', compact('perfiles'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lista de permisos disponibles para asignar al perfil
        $permisosDisponibles = [
            'crear_usuarios',
            'modificar_usuarios',
            'crear_problema',
            'editar_problema',
            'crear_perfiles',
            'editar_perfiles',
            'incluir_contrato',
            'editar_contrato',
            'asignar_ticket',
            'crear_ticket',
            'cerrar_ticket',
            'inhabilitar_usuarios',
        ];

        // Retornar vista de creación con los permisos disponibles
        return view('mantenedores.perfil.create', compact('permisosDisponibles'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los campos
        $request->validate([
            'perfil' => 'required|string|max:100',
            'permisos' => 'nullable|array',
        ]);

        // Crear el nuevo perfil
        \App\Models\Perfil::create([
            'perfil' => $request->perfil,
            'status' => 1, // Activo por defecto
            'permisos' => $request->permisos ?? [], // se guarda como array que se convertirá a JSON
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirigir a la lista o donde estimes mejor
        return redirect()->route('perfiles.index')->with('success', 'Perfil creado exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(perfil $perfil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Buscar el perfil o lanzar 404 si no existe
        $perfil = \App\Models\Perfil::findOrFail($id);

        // Lista de permisos disponibles (mismos que usaste en create)
        $permisosDisponibles = [
            'crear_usuarios',
            'modificar_usuarios',
            'crear_problema',
            'editar_problema',
            'crear_perfiles',
            'editar_perfiles',
            'incluir_contrato',
            'editar_contrato',
            'asignar_ticket',
            'crear_ticket',
            'cerrar_ticket',
            'inhabilitar_usuarios',
        ];

        // Retornar vista de edición
        return view('mantenedores.perfil.update', compact('perfil', 'permisosDisponibles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'perfil' => 'required|string|max:100',
            'status' => 'required|in:0,1',
            'permisos' => 'nullable|array',
        ]);

        // Buscar el perfil
        $perfil = \App\Models\Perfil::findOrFail($id);

        // Actualizar los campos
        $perfil->update([
            'perfil' => $request->perfil,
            'status' => $request->status,
            'permisos' => $request->permisos ?? [], // Si no se seleccionan, guarda array vacío
            'updated_at' => now(),
        ]);

        // Redirigir de vuelta con mensaje de éxito
        return redirect()->route('perfiles.index', $perfil->id)
            ->with('success', 'Perfil actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(perfil $perfil)
    {
        //
    }
}

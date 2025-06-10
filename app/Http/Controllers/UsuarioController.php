<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use App\Models\perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = \App\Models\Usuario::with(['perfil', 'contratos'])->orderBy('created_at', 'desc')->get();

        return view('mantenedores.usuario.index', compact('usuarios'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los perfiles activos para asignar al usuario
        $perfiles = perfil::where('status', 1)->orderBy('perfil')->get();

        // Retornar la vista con la lista de perfiles
        return view('mantenedores.usuario.create', compact('perfiles'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los campos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuario,email',
            'contraseña' => 'required|string|min:6',
            'perfil_id' => 'required|exists:perfil,id',
            'telefono' => 'nullable|string|max:20',
            'especializacion' => 'nullable|string|max:100',
            'fecha_incorporacion' => 'nullable|date',
            'contrato' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Crear usuario
        $usuario = \App\Models\Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'contraseña' => Hash::make($request->contraseña),
            'perfil_id' => $request->perfil_id,
            'telefono' => $request->telefono,
            'especializacion' => $request->especializacion,
            'fecha_incorporacion' => $request->fecha_incorporacion,
            'estado' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Si se subió un archivo de contrato
        if ($request->hasFile('contrato')) {
            $archivo = $request->file('contrato');
            $originalName = $archivo->getClientOriginalName();
            $fileName = uniqid() . '_' . $originalName;
            $filePath = $archivo->storeAs('contratos', $fileName, 'public');

            \App\Models\Contrato::create([
                'id_usuario' => $usuario->id,
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_route' => 'storage/' . $filePath,
                'format' => $archivo->getClientOriginalExtension(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = \App\Models\Usuario::with('contratos')->findOrFail($id);
        $perfiles = \App\Models\Perfil::where('status', 1)->orderBy('perfil')->get();

        return view('mantenedores.usuario.update', compact('usuario', 'perfiles'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar campos del formulario
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuario,email,' . $id,
            'perfil_id' => 'required|exists:perfil,id',
            'telefono' => 'nullable|string|max:20',
            'especializacion' => 'nullable|string|max:100',
            'fecha_incorporacion' => 'nullable|date',
            'estado' => 'required|in:0,1',
            'contrato' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Buscar el usuario
        $usuario = \App\Models\Usuario::findOrFail($id);

        // Actualizar datos del usuario
        $usuario->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'perfil_id' => $request->perfil_id,
            'telefono' => $request->telefono,
            'especializacion' => $request->especializacion,
            'fecha_incorporacion' => $request->fecha_incorporacion,
            'estado' => $request->estado,
            'updated_at' => now(),
        ]);

        // Si se sube un nuevo contrato, lo agregamos como registro adicional
        if ($request->hasFile('contrato')) {
            $archivo = $request->file('contrato');
            $originalName = $archivo->getClientOriginalName();
            $fileName = uniqid() . '_' . $originalName;
            $filePath = $archivo->storeAs('contratos', $fileName, 'public');

            \App\Models\Contrato::create([
                'id_usuario' => $usuario->id,
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_route' => 'storage/' . $filePath,
                'format' => $archivo->getClientOriginalExtension(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('usuarios.index', $usuario->id)
            ->with('success', 'Usuario actualizado correctamente y contrato añadido (si se subió uno nuevo).');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(usuario $usuario)
    {
        //
    }
}

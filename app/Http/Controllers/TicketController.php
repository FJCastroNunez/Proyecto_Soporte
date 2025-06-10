<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\ticket;
use App\Models\Problema;
use App\Models\usuario;
use App\Models\archivo_adjunto;
use App\Models\historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Cargar todos los tickets con sus relaciones
        $tickets = Ticket::with(['cliente', 'asignadoUsuario'])->orderBy('created_at', 'desc')->get();

        return view('app.ticket.index', compact('tickets'));
    }


    public function asignados()
    {
        // Obtén el usuario logueado
        $usuarioId = Auth::user()->id;

        // Obtiene los tickets donde el usuario está asignado
        $tickets = Ticket::where('asignado', $usuarioId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Retorna la vista con los tickets asignados
        return view('app.ticket.index', compact('tickets'));
    }

    public function creados()
    {
        $usuarioId = Auth::user()->id;

        $tickets = Ticket::where('id_creador', $usuarioId) // Suponiendo que el campo se llama 'creador'
            ->orderBy('created_at', 'desc')
            ->get();

        return view('app.ticket.index', compact('tickets'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = cliente::where('status', 1)->get();
        $problemas = Problema::where('status', 1)->get();
        $usuario = Auth::user();
        $usuarios = usuario::where('estado', 1)->get();

        return view('app.ticket.create', compact('usuario', 'problemas', 'clientes', 'usuarios'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'cliente_id' => 'required|integer',
            'descripcion' => 'required|string|max:1000',
            'tipo_problema' => 'required|integer|exists:problema,id',
            'urgencia' => 'required|integer',
            'comentario' => 'nullable|string|max:1000',
            'archivo' => 'nullable|file|max:10240', // hasta 10MB
        ]);

        // Crear el ticket
        $ticket = Ticket::create([
            'id_creador' => Auth::id(),
            'asignado' => $request->asignado ?? null,
            'descripcion' => $request->descripcion,
            'tipo_problema' => $request->tipo_problema,
            'urgencia' => $request->urgencia,
            'id_cliente' => $request->cliente_id,
            'estado' => 1, // Activo por defecto
        ]);


        // Registro de historial: creación
        historial::create([
            'id_usuario' => Auth::id(),
            'comentario' => 'El ticket fue creado por ' . Auth::user()->nombre,
            'id_ticket' => $ticket->id,
            'created_at' => now(),
        ]);

        // Registro si fue asignado
        if ($request->filled('asignado')) {
            $usuarioAsignado = usuario::find($request->asignado);
            $nombreAsignado = $usuarioAsignado ? $usuarioAsignado->nombre : 'usuario desconocido';

            historial::create([
                'id_usuario' => Auth::id(),
                'comentario' => "El ticket fue asignado a {$nombreAsignado} (ID: {$request->asignado})",
                'id_ticket' => $ticket->id,
                'created_at' => now(),
            ]);
        }

        // Comentario inicial del usuario
        if ($request->filled('comentario')) {
            historial::create([
                'id_usuario' => Auth::id(),
                'comentario' => $request->comentario,
                'id_ticket' => $ticket->id,
                'created_at' => now(),
            ]);
        }

        // Archivo adjunto
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('adjuntos_tickets', $fileName, 'public');

            archivo_adjunto::create([
                'id_ticket' => $ticket->id,
                'id_usuario' => Auth::id(),
                'original_name' => $file->getClientOriginalName(),
                'file_name' => $fileName,
                'file_route' => $path,
                'format' => $file->getClientOriginalExtension(),
            ]);

            // Registro en historial que se subió un archivo
            historial::create([
                'id_usuario' => Auth::id(),
                'comentario' => 'Se adjuntó el archivo "' . $file->getClientOriginalName() . '" al ticket.',
                'id_ticket' => $ticket->id,
                'created_at' => now(),
            ]);
        }



        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $clientes = Cliente::where('status', 1)->get();
        $usuarios = Usuario::where('estado', 1)->get();
        $problemas = Problema::where('status', 1)->get();
        $historial = historial::where('id_ticket', $ticket->id)->get();
        $archivos = archivo_adjunto::where('id_ticket', $ticket->id)->get();
        if ($ticket->estado == 1) {
            return view('app.ticket.edit', compact('ticket', 'clientes', 'usuarios', 'problemas', 'historial', 'archivos'));
        } else {
            return view('app.ticket.lectura', compact('ticket', 'clientes', 'usuarios', 'problemas', 'historial', 'archivos'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_cliente' => 'required|exists:cliente,id',
            'descripcion' => 'required|string|max:1000',
            'tipo_problema' => 'required|exists:problema,id',
            'urgencia' => 'required|in:1,2,3',
            'asignado' => 'nullable|exists:usuario,id',
            'razon_cierre' => 'nullable|string',
            'comentario' => 'nullable|string',
            'archivo' => 'nullable|file|max:2048',
        ]);

        $ticket = Ticket::findOrFail($id);

        $ticket->id_cliente = $request->id_cliente;
        $ticket->descripcion = $request->descripcion;
        $ticket->tipo_problema = $request->tipo_problema;
        $ticket->urgencia = $request->urgencia;
        $ticket->asignado = $request->asignado;
        $ticket->updated_at = now();

        $ticket->save();

        // Guardar archivo si viene
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $ruta = $archivo->store('adjuntos', 'public');

            archivo_adjunto::create([
                'id_ticket' => $ticket->id,
                'nombre' => $archivo->getClientOriginalName(),
                'ruta' => $ruta,
            ]);

            Historial::create([
                'id_ticket' => $ticket->id,
                'id_usuario' => Auth::id(),
                'comentario' => 'Se adjuntó el archivo "' . $archivo->getClientOriginalName() . '" al ticket.',
            ]);
        }
        Historial::create([
            'id_ticket' => $ticket->id,
            'id_usuario' => Auth::id(),
            'comentario' =>  $request->comentario,
            'created_at' => now()
        ]);
        // Solo registrar en historial si cambió el usuario asignado
        if ($request->filled('asignado') || $ticket->asignado != $request->asignado) {
            $usuarioAsignado = usuario::find($request->asignado);
            $nombreAsignado = $usuarioAsignado ? $usuarioAsignado->nombre : 'usuario desconocido';

            historial::create([
                'id_usuario' => Auth::id(),
                'comentario' => "El ticket fue asignado a {$nombreAsignado} (ID: {$request->asignado})",
                'id_ticket' => $ticket->id,
                'created_at' => now(),
            ]);
        }

        if ($request->cerrar_ticket == 1) {
            $usuarioactual = usuario::where('id', Auth::id())->get()->shift();

            historial::create([
                'id_usuario' => Auth::id(),
                'comentario' => "El ticket fue cerrado por " . $usuarioactual->nombre,
                'id_ticket' => $ticket->id,
                'created_at' => now(),
            ]);

            historial::create([
                'id_usuario' => Auth::id(),
                'comentario' => $request->razon_cierre,
                'id_ticket' => $ticket->id,
                'created_at' => now(),
            ]);

            $ticket->update([
                'estado' => 2
            ]);
        }
        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ticket $ticket)
    {
        //
    }
}

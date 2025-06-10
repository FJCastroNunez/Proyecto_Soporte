@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Ticket #{{ $ticket->id }}</h1>
    {{-- Alerta de éxito --}}
    @if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Cliente --}}
        <div class="mb-3">
            <label for="id_cliente" class="form-label">Cliente:</label>
            <select name="id_cliente" id="id_cliente" class="form-select" disabled>
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ $cliente->id == $ticket->id_cliente ? 'selected' : '' }}>
                    {{ $cliente->nombre }} ({{ $cliente->correo }})
                </option>
                @endforeach
            </select>
        </div>

        {{-- Asignado --}}
        <div class="mb-3">
            <label for="asignado" class="form-label">Asignado a:</label>
            <select name="asignado" id="asignado" class="form-select" disabled>
                <option value="">-- Sin asignar --</option>
                @foreach ($usuarios as $usuario)
                <option value="{{ $usuario->id }}" {{ $usuario->id == $ticket->asignado ? 'selected' : '' }}>
                    {{ $usuario->nombre }} ({{ $usuario->email }})
                </option>
                @endforeach
            </select>
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" disabled>{{ $ticket->descripcion }}</textarea>
        </div>

        {{-- Estado del ticket --}}
        <div class="mb-3">
            <label for="estado" class="form-label">Estado:</label>
            <select name="estado" id="estado" class="form-select" disabled>
                <option value="1" {{ $ticket->estado == 1 ? 'selected' : '' }}>Abierto</option>
                <option value="2" {{ $ticket->estado == 2 ? 'selected' : '' }}>Cerrado</option>
            </select>
        </div>

        {{-- Tipo de problema --}}
        <div class="mb-3">
            <label for="tipo_problema" class="form-label">Tipo de Problema:</label>
            <select name="tipo_problema" id="tipo_problema" class="form-select" disabled>
                @foreach ($problemas as $problema)
                <option value="{{ $problema->id }}" {{ $problema->id == $ticket->tipo_problema ? 'selected' : '' }}>
                    {{ $problema->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Urgencia --}}
        <div class="mb-3">
            <label for="urgencia" class="form-label">Urgencia:</label>
            <select name="urgencia" id="urgencia" class="form-select" disabled>
                <option value="1" {{ $ticket->urgencia == 1 ? 'selected' : '' }}>Baja</option>
                <option value="2" {{ $ticket->urgencia == 2 ? 'selected' : '' }}>Media</option>
                <option value="3" {{ $ticket->urgencia == 3 ? 'selected' : '' }}>Alta</option>
                <option value="4" {{ $ticket->urgencia == 4 ? 'selected' : '' }}>Crítica</option>
            </select>
        </div>

        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
            ← Volver
        </a>

    </form>

    <hr>

    <h3>Historial del Ticket</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Comentario</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ticket->historial as $item)
            <tr>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->usuario->nombre ?? 'N/A' }}</td>
                <td>{{ $item->comentario }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    @if ($ticket->adjuntos->isNotEmpty())
    <div class="mt-5">
        <h4 class="mb-3">📎 Archivos Adjuntos</h4>
        <ul class="list-group">
            @foreach ($ticket->adjuntos as $adjunto)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-file-earmark-text-fill"></i>
                    {{ $adjunto->original_name }}
                </div>
                <a href="{{ asset('storage/' . $adjunto->file_route) }}" target="_blank" class="btn btn-sm btn-primary">
                    Ver archivo
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @else
    <div class="mt-5">
        <h4 class="mb-3">📎 Archivos Adjuntos</h4>
        <p class="text-muted">No hay archivos adjuntos para este ticket.</p>
    </div>
    @endif



</div>

<script>
    function mostrarRazonCierre(value) {
        document.getElementById('razon_cierre_container').style.display = value == "1" ? 'block' : 'none';
    }
</script>
@endsection
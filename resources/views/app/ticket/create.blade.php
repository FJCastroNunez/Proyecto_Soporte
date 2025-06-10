@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Título + Botones --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Crear nuevo ticket</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                    ← Volver
                </a>
                <button type="submit" class="btn btn-primary">Crear ticket</button>
            </div>
        </div>

        {{-- Alerta de éxito --}}
        @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
        @endif

        {{-- Errores --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Sección 1: Datos del Cliente --}}
        <div class="mb-4">
            <label for="cliente_id" class="form-label">Seleccionar Cliente:</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">-- Selecciona un cliente --</option>
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">
                    {{ $cliente->rut }} - {{ $cliente->nombre }} ({{ $cliente->correo }})
                </option>
                @endforeach
            </select>
        </div>
        {{-- Botón para crear cliente si no existe --}}
        <div class="mt-2">
            <a href="{{ route('clientes.create') }}" class="btn btn-outline-primary btn-sm">
                ¿No encuentras al cliente? Regístralo aquí
            </a>
        </div>

        {{-- Sección 2: Datos del Ticket --}}
        <h2 class="mt-4 mb-3">Datos del Ticket</h2>
        <div class="border rounded p-3 mb-4">
            <div class="mb-3">
                <label for="descripcion">Descripción del problema:</label>
                <textarea name="descripcion" class="form-control" id="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="tipo_problema">Tipo de problema:</label>
                <select name="tipo_problema" id="tipo_problema" class="form-select" required>
                    <option value="">-- Selecciona --</option>
                    @foreach ($problemas as $problema)
                    <option value="{{ $problema->id }}">{{ $problema->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-0">
                <label for="urgencia">Urgencia:</label>
                <select name="urgencia" id="urgencia" class="form-select" required>
                    <option value="">-- Selecciona --</option>
                    <option value="1">Baja</option>
                    <option value="2">Media</option>
                    <option value="3">Alta</option>
                    <option value="4">Crítica</option>
                </select>
            </div>
        </div>

        {{-- Sección 3: Comentario y Adjuntos --}}
        <h2 class="mt-4 mb-3">Comentario y Adjuntos</h2>
        <div class="border rounded p-3 mb-4">
            <div class="mb-3">
                <label for="comentario">Comentario inicial:</label>
                <textarea class="form-control" name="comentario" id="comentario" rows="3">{{ old('comentario') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="archivo">Archivo adjunto (opcional):</label>
                <input class="form-control" type="file" name="archivo" id="archivo" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
            </div>

            <div>
                <label for="asignado">Asignar a:</label>
                <select name="asignado" id="asignado" class="form-select">
                    <option value="">-- Selecciona un usuario --</option>
                    @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->nombre }} ({{ $usuario->email }})</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cliente_id').select2({
            placeholder: 'Busca por ID, nombre, correo o RUT...',
            width: '100%',
            allowClear: true,
            matcher: function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                var term = params.term.toLowerCase();
                var text = (data.text || '').toLowerCase();
                if (text.includes(term)) {
                    return data;
                }
                return null;
            }
        });
        $('#asignado').select2({
            placeholder: 'Busca un usuario...',
            width: '100%'
        });
    });
</script>
@endsection
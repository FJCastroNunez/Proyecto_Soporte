@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar cliente</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h2 class="mb-3">Datos del Cliente</h2>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de cliente</label>
                    <select name="tipo" id="tipo" class="form-select" required>
                        <option value="1" {{ $cliente->tipo == 1 ? 'selected' : '' }}>Empresa</option>
                        <option value="2" {{ $cliente->tipo == 2 ? 'selected' : '' }}>Particular</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="rut" class="form-label">RUT</label>
                    <input type="text" name="rut" id="rut" value="{{ old('rut', $cliente->rut) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" name="correo" id="correo" value="{{ old('correo', $cliente->correo) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $cliente->direccion) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Estado</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="1" {{ $cliente->status == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ $cliente->status == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                        ← Volver
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Actualizar cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
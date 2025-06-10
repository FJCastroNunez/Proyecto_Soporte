@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar problema</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
    @endif

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Formulario de edición --}}
    <form action="{{ route('problemas.update', $problema->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div>
            <label for="nombre">Nombre del problema:</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $problema->nombre) }}" required>
        </div>

        <div>
            <label for="status">Estado:</label>
            <select name="status" id="status" required>
                <option value="1" {{ $problema->status == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $problema->status == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <a href="{{ route('problemas.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
        <button type="submit">Actualizar</button>
    </form>
</div>
@endsection
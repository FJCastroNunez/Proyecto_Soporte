@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear nuevo perfil</h1>

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

    <form action="{{ route('perfiles.store') }}" method="POST">
        @csrf

        <div>
            <label for="perfil">Nombre del perfil:</label>
            <input type="text" name="perfil" id="perfil" value="{{ old('perfil') }}" required>
        </div>

        <div>
            <label>Permisos:</label><br>
            @foreach ($permisosDisponibles as $permiso)
            <label>
                <input type="checkbox" name="permisos[]" value="{{ $permiso }}">
                {{ ucfirst(str_replace('_', ' ', $permiso)) }}
            </label><br>
            @endforeach
        </div>
        <a href="{{ route('perfiles.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
        <button type="submit">Guardar perfil</button>
    </form>
</div>
@endsection
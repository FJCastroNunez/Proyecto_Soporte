@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar perfil</h1>

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

    <form action="{{ route('perfiles.update', $perfil->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="perfil">Nombre del perfil:</label>
            <input type="text" name="perfil" id="perfil" value="{{ old('perfil', $perfil->perfil) }}" required>
        </div>

        <div>
            <label for="status">Estado:</label>
            <select name="status" id="status" required>
                <option value="1" {{ $perfil->status == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $perfil->status == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div>
            <label>Permisos:</label><br>
            @foreach ($permisosDisponibles as $permiso)
            <label>
                <input type="checkbox" name="permisos[]" value="{{ $permiso }}"
                    {{ in_array($permiso, $perfil->permisos ?? []) ? 'checked' : '' }}>
                {{ ucfirst(str_replace('_', ' ', $permiso)) }}
            </label><br>
            @endforeach
        </div>
        <a href="{{ route('perfiles.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
        <button type="submit">Actualizar perfil</button>
    </form>
</div>
@endsection
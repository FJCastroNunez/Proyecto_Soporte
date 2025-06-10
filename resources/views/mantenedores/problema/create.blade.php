@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear nuevo problema</h1>

    <form action="{{ route('problemas.store') }}" method="POST">
        @csrf
        <div>
            <label for="nombre">Nombre del problema:</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <a href="{{ route('problemas.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
        <button type="submit">Guardar</button>
    </form>
</div>
@endsection
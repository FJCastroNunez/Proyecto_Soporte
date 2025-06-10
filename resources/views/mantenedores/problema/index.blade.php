@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Listado de Problemas</h1>

    <a href="{{ route('problemas.create') }}" class="btn btn-success mb-3">
        + Crear nuevo problema
    </a>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Tabla de problemas --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="tabla-problemas" class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($problemas as $problema)
                    <tr>
                        <td>{{ $problema->id }}</td>
                        <td>{{ $problema->nombre }}</td>
                        <td>
                            <span class="badge bg-{{ $problema->status == 1 ? 'success' : 'danger' }}">
                                {{ $problema->status == 1 ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>{{ $problema->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('problemas.edit', $problema->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay problemas registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#tabla-problemas').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            responsive: true,
            autoWidth: false
        });
    });
</script>
@endsection
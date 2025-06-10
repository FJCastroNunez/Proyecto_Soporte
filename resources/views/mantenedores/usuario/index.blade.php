@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Listado de Usuarios</h1>

    {{-- Botón para crear nuevo usuario --}}
    <a href="{{ route('usuarios.create') }}" class="btn btn-success mb-3">
        + Crear nuevo usuario
    </a>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Tabla de usuarios --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="tabla-usuarios" class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Perfil</th>
                        <th>Estado</th>
                        <th>Contrato</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->perfil->perfil ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $usuario->estado ? 'success' : 'danger' }}">
                                {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            @if($usuario->contratos->isNotEmpty())
                            ✔️ {{ $usuario->contratos->count() }} contrato(s)
                            @else
                            ❌ Sin contrato
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay usuarios registrados.</td>
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
        $('#tabla-usuarios').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            responsive: true,
            autoWidth: false
        });
    });
</script>
@endsection
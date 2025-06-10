@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Listado de Perfiles</h1>

    {{-- Botón para crear nuevo perfil --}}
    <a href="{{ route('perfiles.create') }}" class="btn btn-primary mb-3">
        + Crear nuevo perfil
    </a>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Tabla de perfiles --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="tabla-perfiles" class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre del perfil</th>
                        <th>Estado</th>
                        <th>Permisos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perfiles as $perfil)
                    <tr>
                        <td>{{ $perfil->id }}</td>
                        <td>{{ $perfil->perfil }}</td>
                        <td>
                            <span class="badge bg-{{ $perfil->status == 1 ? 'success' : 'danger' }}">
                                {{ $perfil->status == 1 ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            @if($perfil->permisos && is_array($perfil->permisos))
                            <ul class="mb-0">
                                @foreach ($perfil->permisos as $permiso)
                                <li>{{ ucfirst(str_replace('_', ' ', $permiso)) }}</li>
                                @endforeach
                            </ul>
                            @else
                            <em>Sin permisos</em>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('perfiles.edit', $perfil->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay perfiles registrados.</td>
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
        $('#tabla-perfiles').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            responsive: true,
            autoWidth: false
        });
    });
</script>
@endsection
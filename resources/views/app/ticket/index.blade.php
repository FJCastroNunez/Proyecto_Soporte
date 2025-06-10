@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Listado de Tickets</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('tickets.create') }}" class="btn btn-success mb-3">Crear nuevo ticket</a>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="tabla-tickets" class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Cliente</th>
                        <th>Asignado a</th>
                        <th>Urgencia</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ Str::limit($ticket->descripcion, 40) }}</td>
                        <td>{{ $ticket->cliente->nombre ?? 'N/A' }}</td>
                        <td>{{ $ticket->asignadoUsuario->nombre ?? 'Sin asignar' }}</td>
                        <td>
                            @php
                            $urgencias = ['1' => 'Baja', '2' => 'Media', '3' => 'Alta', '4' => 'Crítica'];
                            @endphp
                            {{ $urgencias[$ticket->urgencia] ?? 'N/A' }}
                        </td>
                        <td>
                            <span class="badge bg-{{ $ticket->estado == 1 ? 'success' : 'danger' }}">
                                {{ $ticket->estado == 1 ? 'Abierto' : 'Cerrado' }}
                            </span>
                        </td>
                        <td>{{ $ticket->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            @if($ticket->estado == 1)
                            @php
                            $dias = $ticket->dias_habiles_restantes;
                            $clase = $dias > 3 ? 'btn-success' : ($dias >= 1 ? 'btn-warning' : 'btn-danger');
                            @endphp
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm {{ $clase }}">
                                Editar ({{ $dias }} días)
                            </a>
                            @else
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning">
                                Ver
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay tickets registrados.</td>
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
        $('#tabla-tickets').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            responsive: true,
            autoWidth: false
        });
    });
</script>
@endsection
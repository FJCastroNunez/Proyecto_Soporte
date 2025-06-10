@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel de Notificaciones del Administrador</h1>
</div>
@endsection

@section('scripts')
<script>
    Swal.fire({
        icon: 'info',
        title: 'Clientes nuevos',
        text: 'Se han creado {{ $clientesNuevos }} nuevos clientes hoy.',
        timer: 5000,
        timerProgressBar: true,
        toast: true,
        position: 'top-end',
        showConfirmButton: false
    });
</script>
@endsection
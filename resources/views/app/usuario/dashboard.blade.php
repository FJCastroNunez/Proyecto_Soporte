@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bienvenido, {{ auth()->user()->nombre }}</h1>
</div>
@endsection

@section('scripts')
<script>
    @if($ticketsPorVencer > 0)
    Swal.fire({
        icon: 'warning',
        title: 'Tickets por vencer',
        text: 'Tienes {{ $ticketsPorVencer }} tickets por vencer.',
        timer: 5000,
        timerProgressBar: true,
        toast: true,
        position: 'top-end',
        showConfirmButton: false
    });
    @endif

    @if($ticketsVencidos > 0)
    Swal.fire({
        icon: 'error',
        title: 'Tickets vencidos',
        text: 'Tienes {{ $ticketsVencidos }} tickets vencidos.',
        timer: 5000,
        timerProgressBar: true,
        toast: true,
        position: 'top-end',
        showConfirmButton: false
    });
    @endif
</script>
@endsection
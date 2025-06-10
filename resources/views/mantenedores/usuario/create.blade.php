@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear nuevo usuario</h1>

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

    <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div>
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" id="contraseña" required>
        </div>

        <div>
            <label for="perfil_id">Perfil:</label>
            <select name="perfil_id" id="perfil_id" required>
                <option value="">-- Selecciona un perfil --</option>
                @foreach($perfiles as $perfil)
                <option value="{{ $perfil->id }}" {{ old('perfil_id') == $perfil->id ? 'selected' : '' }}>
                    {{ $perfil->perfil }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}">
        </div>

        <div>
            <label for="especializacion">Especialización:</label>
            <input type="text" name="especializacion" id="especializacion" value="{{ old('especializacion') }}">
        </div>

        <div>
            <label for="fecha_incorporacion">Fecha de incorporación:</label>
            <input type="date" name="fecha_incorporacion" id="fecha_incorporacion" value="{{ old('fecha_incorporacion') }}">
        </div>

        <div>
            <label for="contrato">Contrato (opcional):</label>
            <input type="file" name="contrato" id="contrato" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="mostrarVistaPrevia(this)">
        </div>

        <div id="vista-previa-contrato" style="margin-top: 10px;"></div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
        <button type="submit">Guardar usuario</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function mostrarVistaPrevia(input) {
        const previewDiv = document.getElementById('vista-previa-contrato');
        previewDiv.innerHTML = '';

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileType = file.type;

            if (fileType.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.maxWidth = '200px';
                img.style.marginTop = '10px';
                previewDiv.appendChild(img);
            } else if (fileType === 'application/pdf') {
                const iframe = document.createElement('iframe');
                iframe.src = URL.createObjectURL(file);
                iframe.style.width = '100%';
                iframe.style.height = '400px';
                previewDiv.appendChild(iframe);
            } else {
                const text = document.createElement('p');
                text.innerText = `Archivo seleccionado: ${file.name}`;
                previewDiv.appendChild(text);
            }
        }
    }
</script>
@endsection
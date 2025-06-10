@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar usuario</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
        </div>

        <div>
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}" required>
        </div>

        <div>
            <label for="perfil_id">Perfil:</label>
            <select name="perfil_id" id="perfil_id" required>
                <option value="">-- Selecciona un perfil --</option>
                @foreach($perfiles as $perfil)
                <option value="{{ $perfil->id }}" {{ $usuario->perfil_id == $perfil->id ? 'selected' : '' }}>
                    {{ $perfil->perfil }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $usuario->telefono) }}">
        </div>

        <div>
            <label for="especializacion">Especialización:</label>
            <input type="text" name="especializacion" id="especializacion" value="{{ old('especializacion', $usuario->especializacion) }}">
        </div>

        <div>
            <label for="fecha_incorporacion">Fecha de incorporación:</label>
            <input type="date" name="fecha_incorporacion" id="fecha_incorporacion"
                value="{{ old('fecha_incorporacion', optional($usuario->fecha_incorporacion)->format('d-m-Y')) }}">
        </div>

        <div>
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="1" {{ $usuario->estado == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $usuario->estado == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div>
            <label for="contrato">Subir nuevo contrato (opcional):</label>
            <input type="file" name="contrato" id="contrato" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="mostrarVistaPrevia(this)">
        </div>

        <div id="vista-previa-contrato" style="margin-top: 10px;"></div>

        {{-- Tabla de contratos anteriores --}}
        @if($usuario->contratos && count($usuario->contratos))
        <h3>Contratos anteriores:</h3>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Archivo</th>
                    <th>Formato</th>
                    <th>Fecha</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuario->contratos as $contrato)
                <tr>
                    <td>{{ $contrato->original_name }}</td>
                    <td>{{ strtoupper($contrato->format) }}</td>
                    <td>{{ \Carbon\Carbon::parse($contrato->created_at)->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ asset($contrato->file_route) }}" target="_blank">Ver archivo</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
            ← Volver
        </a>
        <button type="submit" style="margin-top: 15px;">Actualizar usuario</button>
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
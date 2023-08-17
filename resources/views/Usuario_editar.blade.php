<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    @include('link')
    <style>
        /* Aplica el estilo del fondo */
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    @include('menu')
    <div class="container">
        <h1 class="mt-5">Editar Usuario</h1>
        @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
        @endif

        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('usuario.update', $usuario->cedula) }}" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->nombre }}" onkeypress="return soloLetras(event,'nombre')" onpaste="return validarContenido(event,'nombre')" placeholder="Ingrese el nombre" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-nombre" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras y espacios en el nombre.
                </div>
            </div>

            <div class="form-group">
                <label for="apellidos">Apellido:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ $usuario->apellidos }}" onkeypress="return soloLetras(event,'apellidos')" onpaste="return validarContenido(event,'apellidos')" placeholder="Ingrese los apellidos" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-apellidos" style="display: none;">
                <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras y espacios en el apellido.
                </div>
            </div>

            <div class="form-group">
                <label for="cedula">Número de cédula:</label>
                <input type="text" class="form-control" id="cedula" name="cedula" value="{{ $usuario->cedula }}" onkeypress="return soloNumeros(event,'cedula')" onpaste="return validarPegadoNumero(event,'cedula')" placeholder="Ingrese el número de cédula" required pattern="[0-9]+" title="Solo se permiten números" readonly>
                <div class="alert alert-danger mt-2" id="mensaje-error-cedula" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Solo se permiten números.
                </div>
            </div>
            <div class="form-group">
                <label for="correo">Correo electrónico @:</label>
                <input type="email" name="correo" id="correo" class="form-control" value="{{ $usuario->correo }}" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" value="{{ $usuario->password }}" class="form-control" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ $usuario->fecha_nacimiento }}" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $usuario-> telefono }}" onkeypress="return soloNumeros(event,'telefono')" onpaste="return validarPegadoNumero(event,'telefono')" placeholder="Ingrese el número de telefono" required pattern="[0-9]+" title="Solo se permiten números" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-telefono" style="display: none;">
                <i class="bi bi-exclamation-triangle"></i> Solo se permiten números.
                </div>
            </div>
            <div class="form-group">
                <label for="fotografia">Fotografía:</label>
                <input type="file" name="fotografia" id="fotografia" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="id_cliente">Rol del Usuario:</label>
                <select name="idrol" id="idrol" class="form-control" required>
                    @foreach ($roles as $rol)
            @if ($rol->id != 99) <!-- Excluir el rol de Super Usuario -->
                <option value="{{ $rol->id }}" {{ $rol->id == $usuario->idrol ? 'selected' : '' }}>{{ $rol->nombre }}</option>
            @endif
        @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="estatus">Estatus:</label>
                <select name="estatus" id="estatus" class="form-control" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary col-md-6 offset-md-3">Actualizar</button>
                <br></br>
                <a class="btn btn-secondary col-md-6 offset-md-3" href="{{ route('Usuario_index') }}" role="button">Volver al Inicio</a>
            </div>
        </form>
    </div>
    @include('fooder') 
</body>
</html>
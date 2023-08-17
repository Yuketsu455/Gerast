<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    @include('link')
    <link rel="stylesheet" href="ruta-a-tu-archivo.css"> <!-- Enlace al archivo CSS externo -->
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
    <div class="form-container">
        <h1 class="mt-5">Agregar Usuario</h1>
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

        <form method="POST" action="{{ route('usuario.store') }}" class="mt-4">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" onkeypress="return soloLetras(event,'nombre')" onpaste="return validarContenido(event,'nombre')" placeholder="Ingrese el nombre" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-nombre" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras y espacios en el nombre.
                </div>
            </div>

            <div class="form-group">
                <label for="apellidos">Apellido:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" onkeypress="return soloLetras(event,'apellidos')" onpaste="return validarContenido(event,'apellidos')" placeholder="Ingrese los apellidos" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-apellidos" style="display: none;">
                <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras y espacios en el apellido.
                </div>
            </div>

            <div class="form-group">
                <label for="cedula">Número de cédula:</label>
                <input type="text" class="form-control" id="cedula" name="cedula" onkeypress="return soloNumeros(event,'cedula')" onpaste="return validarPegadoNumero(event,'cedula')" placeholder="Ingrese el número de cédula" required pattern="[0-9]+" title="Solo se permiten números" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-cedula" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Solo se permiten números.
                </div>
            </div>

            <div class="form-group">
                <label for="correo">Correo electrónico @:</label>
                <input type="email" name="correo" id="correo" class="form-control" onblur="validarCorreo()" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-correo" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Correo electrónico inválido.
                </div>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" onkeypress="return soloNumeros(event,'telefono')" onpaste="return validarPegadoNumero(event,'telefono')" placeholder="Ingrese el número de telefono" required pattern="[0-9]+" title="Solo se permiten números" required>
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
                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
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
                <button type="submit" class="btn btn-primary col-md-6 offset-md-3">Agregar</button>
                <br><br>
                <a class="btn btn-secondary col-md-6 offset-md-3" href="{{ route('Usuario_index') }}" role="button">Volver al Inicio</a>
            </div>
        </form>
    </div>
</div>
@include('fooder')
</body>
</html>
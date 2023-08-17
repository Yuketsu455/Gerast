<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar cliente</title>
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
        <h2>Editar Cliente</h2>
        <form method="POST" action="{{ route('cliente.update', $cliente->cedula) }}">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cliente->nombre }}" onkeypress="return soloLetras(event,'nombre')" onpaste="return validarContenido(event,'nombre')" placeholder="Ingrese el nombre" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-nombre" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras y espacios en el nombre.
                </div>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ $cliente->apellidos }}" onkeypress="return soloLetras(event,'apellido')" onpaste="return validarContenido(event,'apellido')" placeholder="Ingrese el apellido" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-apellido" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras y espacios en el apellido.
                </div>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" class="form-control" name="correo" value="{{ $cliente->correo }}" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $cliente->telefono }}" onkeypress="return soloNumeros(event,'telefono')" onpaste="return validarPegadoNumero(event,'telefono')" placeholder="Ingrese el número de telefono" required pattern="[0-9]+" title="Solo se permiten números" required>
                <div class="alert alert-danger mt-2" id="mensaje-error-telefono" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Solo se permiten números.
                </div>
            </div>
            <button type="submit" class="btn btn-primary col-md-6 offset-md-3">Actualizar</button>
            <br><br>
            <a class="btn btn-secondary col-md-6 offset-md-3" href="{{ route('Cliente_index') }}" role="button">Volver al Inicio</a>
        </form>
    </div>
</div>
@include('fooder')
</body>
</html>
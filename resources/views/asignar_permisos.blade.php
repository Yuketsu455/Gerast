<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Asignar permisos</title>
    @include('link')
    <style>
        body {
            background-color: #f2f2f2;
        }
        .container {
            margin-top: 50px;
        }
        .module-header {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .module-box {
            background-color: white;
            border: 1px solid #d4d4d4;
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }
        .submit-buttons {
            text-align: center;
            margin-top: 30px;
        }

        .form-check.form-switch {
    margin-left: 25px; /* Ajusta el valor según tu necesidad */
}
    </style>
</head>
<body>
@include('menu')
<div class="container">
    <form method="post" action="{{ route('roles.guardar_permisos', ['id' => $roles->id]) }}">
        @csrf
        <h2 class="text-center mb-4">Asignar permisos para el rol: {{ $roles->nombre }}</h2>
        <div class="row">
            @foreach($modulos as $modulo)
            <div class="col-md-6">
                <div class="module-box">
                    <div class="module-header">{{ $modulo->nombre }}</div>
                    @foreach($modulo->operaciones as $operacion)
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="permiso{{ $operacion->id }}" name="permisos[]" value="{{ $operacion->id }}" {{ collect(optional($roles->permisos)->pluck('id'))->contains($operacion->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permiso{{ $operacion->id }}">{{ $operacion->nombre }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        <div class="submit-buttons">
            <button type="submit" class="btn btn-primary btn-lg">Guardar permisos</button>
            <br><br>
            <a class="btn btn-secondary" href="{{ route('Roles_index') }}" role="button">Volver al Inicio</a>
        </div>
    </form>
</div>
@include('fooder')
</body>
</html>
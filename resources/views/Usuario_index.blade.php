<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    @include('link')
    <style> 
    .btn-icon {
        display: inline-flex;
        align-items: center;
        vertical-align: middle;
    }

    .btn-icon i {
        margin-right: 5px; /* Espacio entre el icono y el texto */
    }
    </style>    

</head>
<body>
@include('menu')
<div class="container mt-5 mx-auto col-md-10">
    <h2 class="text-center mb-4">Usuarios - Lista</h2>
    @if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

<form action="{{ route('usuarios.filter') }}" method="POST" class="mb-4">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <h3>Filtros</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <input type="text" class="form-control" id="nombre" name="nombre" onkeypress="return soloLetras(event,'nombre')" onpaste="return validarContenido(event,'nombre')" placeholder="Busqueda por nombre" @if(request()->filled('nombre')) value="{{ request()->input('nombre') }}" @endif>
                <div class="alert alert-danger mt-2" id="mensaje-error-nombre" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input type="text" class="form-control" id="cedula" name="cedula" onkeypress="return soloNumeros(event,'cedula')" onpaste="return validarPegadoNumero(event,'cedula')" placeholder="Busqueda por Cedula" pattern="[0-9]+" title="Solo se permiten números"  @if(request()->filled('cedula')) value="{{ request()->input('cedula') }}" @endif>
                <div class="alert alert-danger mt-2" id="mensaje-error-cedula" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> Solo se permiten números.
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <div class="form-group">
                <?php
                    $user = auth()->user();
                    if ($user && $user->rol) {
                        $permisoAgregar = $user->rol->permisos()->where('idOperacion', 1)->exists();
                        $permisoEditar = $user->rol->permisos()->where('idOperacion', 2)->exists();
                        $permisoHabilitarDeshabilitar = $user->rol->permisos()->where('idOperacion', 3)->exists();
                    } else {
                        $permisoAgregar = $permisoEditar = $permisoHabilitarDeshabilitar = false;
                    }
                ?>
                <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Filtrar</button>
                <a href="{{ route('Usuario_index') }}" class="btn btn-secondary ml-2"> <i class="bi bi-arrow-counterclockwise"></i> Limpiar filtro</a>
                <?php if ($permisoAgregar): ?>
                    <a href="{{ route('Agregar_Usuario')}}" class="btn btn-success ml-2"><i class="bi bi-person-plus"></i> Agregar Usuario</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-dark table-striped">
        <thead class="thead-dark">
            <tr>
               
                
                <?php if ($permisoEditar): ?>
                    <th>Actualizar</th>
                <?php endif; ?>
                <?php if ($permisoHabilitarDeshabilitar): ?>
                    <th>Habilitar/Deshabilitar</th>
                <?php endif; ?>
                
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Numero de Cedula</th>
                <th>Correo</th>
                <th>Fecha de Nacimiento</th>
                <th>Telefono</th>
                <th>Fotografia</th>
                <th>Rol</th>
                <th>Estatus</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach( $Usuarios as $usuario)
            @if ($usuario->correo !== 'super@gmail.com')
            <tr>
                <?php if ($permisoEditar): ?>
                    <td><a href="{{ route('Usuario_editar', ['cedula' => $usuario->cedula]) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Editar</a></td>
                <?php endif; ?>
                <?php if ($permisoHabilitarDeshabilitar): ?>
                    <td>
                        @if ($usuario->estatus == 'Activo')
                            <form action="{{ route('usuario.deshabilitar', ['cedula' => $usuario->cedula]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Deshabilitar</button>
                            </form>
                        @else
                            <form action="{{ route('usuario.habilitar', ['cedula' => $usuario->cedula]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Habilitar</button>
                            </form>
                        @endif
                    </td>
                <?php endif; ?>

                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->apellidos }}</td>
                <td>{{ $usuario->cedula }}</td>
                <td>{{ $usuario->correo }}</td>
                <td>{{ $usuario->fecha_nacimiento }}</td>
                <td>{{ $usuario->telefono }}</td>
                <td>{{ $usuario->fotografia }}</td>
                <td>{{ $usuario->rol->nombre }}</td>
                <td>{{ $usuario->estatus }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
    <div class="pagination justify-content-center mt-4">
        <ul class="pagination">
            <li class="page-item {{ $Usuarios->currentPage() == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $Usuarios->appends(request()->except('page'))->url(1) }}">Primera</a>
            </li>
            @for ($page = max(1, $Usuarios->currentPage() - 2); $page <= min($Usuarios->lastPage(), $Usuarios->currentPage() + 2); $page++)
                <li class="page-item {{ $page == $Usuarios->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $Usuarios->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                </li>
            @endfor
            <li class="page-item {{ $Usuarios->currentPage() == $Usuarios->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $Usuarios->appends(request()->except('page'))->url($Usuarios->lastPage()) }}">Última</a>
            </li>
        </ul>
    </div>
</div>
@include('fooder')
</body>
</html>
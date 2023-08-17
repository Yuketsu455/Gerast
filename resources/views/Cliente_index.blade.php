<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    @include('link')
    <title>Clientes - Lista</title>
    <style>
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
@include('menu')
<div class="container mt-5">
    <h2 class="text-center mb-4">Clientes</h2>
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
    <form action="{{ route('clientes.filter') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <h3>Busqueda</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" id="nombre" name="nombre" onkeypress="return soloLetras(event,'nombre')" onpaste="return validarContenido(event,'nombre')" placeholder="Ingrese el nombre" @if(request()->filled('nombre')) value="{{ request()->input('nombre') }}" @endif>
                    <div class="alert alert-danger mt-2" id="mensaje-error-nombre" style="display: none;">
                        <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" id="cedula" name="cedula" onkeypress="return soloNumeros(event,'cedula')" onpaste="return validarPegadoNumero(event,'cedula')" placeholder="Ingrese el número de cédula" pattern="[0-9]+" title="Solo se permiten números"  @if(request()->filled('cedula')) value="{{ request()->input('cedula') }}" @endif>
                    <div class="alert alert-danger mt-2" id="mensaje-error-cedula" style="display: none;">
                        <i class="bi bi-exclamation-triangle"></i> Solo se permiten números.
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-group d-flex">
                    <?php
                        $user = auth()->user();
                        if ($user && $user->rol) {
                            $permisoAgregar = $user->rol->permisos()->where('idOperacion', 5)->exists();
                            $permisoEditar = $user->rol->permisos()->where('idOperacion', 6)->exists();
                            $permisoEliminar = $user->rol->permisos()->where('idOperacion', 7)->exists();
                        } else {
                            $permisoAgregar = $permisoEditar = $permisoEliminar = false;
                        }
                    ?>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('Cliente_index') }}" class="btn btn-secondary ml-2">
                        <i class="bi bi-arrow-counterclockwise"></i> Limpiar filtro
                    </a>
                    @if ($permisoAgregar)
                    <a href="{{ route('Agregar_cliente')}}" class="btn btn-success ml-2">
                        <i class="bi bi-person-plus"></i> Agregar Cliente
                    </a>
                    @endif
                    <a href="{{ route('clientes.pdf',[ 'nombre' => request('nombre'), 'cedula' => request('cedula')]) }}" class="btn btn-info ml-2">
                        <i class="bi bi-printer-fill"></i>Generar Reporte
                    </a>
                </div>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Número de cédula</th>
                    <th>Correo electrónico</th>
                    <th>Teléfono</th>
                    @if ($permisoEditar)
                    <th>Actualizar</th>
                    @endif
                    @if ($permisoEliminar)
                    <th>Eliminar</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach( $Clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->apellidos }}</td>
                    <td>{{ $cliente->cedula }}</td>
                    <td>{{ $cliente->correo }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    @if ($permisoEditar)
                    <td><a class="btn btn-primary" href="{{ route('Cliente_editar', ['cedula' => $cliente->cedula]) }}" role="button"><i class="bi bi-pencil-square"></i> Editar</a></td>
                    @endif
                    @if ($permisoEliminar)
                    <td><a class="btn btn-danger" href="{{ route('eliminar_cliente', ['cedula' => $cliente->cedula]) }}"   role="button" onclick="event.preventDefault();
                        if (confirm('¿Estás seguro de eliminar este cliente?')) {
                            document.getElementById('eliminar-form-{{ $cliente->cedula }}').submit();
                        }" ><i class="bi bi-trash"></i> Eliminar  </a>

                        <form id="eliminar-form-{{ $cliente->cedula }}" action="{{ route('eliminar_cliente', ['cedula' => $cliente->cedula]) }}" 
                        method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="pagination justify-content-center mt-4">
    <ul class="pagination">
        <li class="page-item {{ $Clientes->currentPage() == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $Clientes->appends(request()->except('page'))->url(1) }}">Primera</a>
        </li>
        @for ($page = max(1, $Clientes->currentPage() - 2); $page <= min($Clientes->lastPage(), $Clientes->currentPage() + 2); $page++)
            <li class="page-item {{ $page == $Clientes->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $Clientes->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
            </li>
        @endfor
        <li class="page-item {{ $Clientes->currentPage() == $Clientes->lastPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $Clientes->appends(request()->except('page'))->url($Clientes->lastPage()) }}">Última</a>
        </li>
    </ul>
</div>
</div>
@include('fooder')
</body>
</html>
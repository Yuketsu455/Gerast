<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    @include('link')
    <title>Roles - Lista</title>
    <style>
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
@include('menu')
<div class="container mt-5">
    <h2 class="text-center mb-4">Roles</h2>
    <form action="{{ route('roles.filter') }}" method="POST" class="mb-4">
        @csrf
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nombre">Nombre del rol:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" @if(request()->filled('nombre')) value="{{ request()->input('nombre') }}" @endif>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-group">
                    <?php
                        $user = auth()->user();
                        if ($user && $user->rol) {
                            $permisoAgregar = $user->rol->permisos()->where('idOperacion', 15)->exists();
                            $permisoConfigurar = $user->rol->permisos()->where('idOperacion', 16)->exists();
                            $permisoEliminar = $user->rol->permisos()->where('idOperacion', 17)->exists();
                        } else {
                            $permisoAgregar = $permisoConfigurar = $permisoEliminar = false;
                        }
                    ?>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Filtrar</button>
                    <a href="{{ route('Roles_index') }}" class="btn btn-secondary ml-2"> <i class="bi bi-arrow-counterclockwise"></i> Limpiar filtro</a>
                    @if ($permisoAgregar)
                    <a href="{{ route('Agregar_Rol')}}" class="btn btn-success ml-2"><i class="bi bi-plus-circle"></i> Agregar Rol</a>
                    @endif
                </div>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered table-dark table-striped">
            <thead>
                <tr>
                    <th>Id Rol</th>
                    <th>Nombre</th>
                    @if ($permisoConfigurar)
                    <th>Configuración</th>
                    @endif
                    @if ($permisoEliminar)
                    <th>Eliminar</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach( $Roles as $roles)
                <tr>
                    <td>{{ $roles->id }}</td>
                    <td>{{ $roles->nombre }}</td>
                    @if ($permisoConfigurar)
                    <td><a href="{{ route('roles.permisos', ['id' => $roles->id]) }}" class="btn btn-primary" role="button"><i class="bi bi-nut-fill"></i> Configurar permisos</a></td>
                    @endif
                    @if ($permisoEliminar)
                    <td><form action="{{ route('roles.destroy', $roles->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</button>
                    </form></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination justify-content-center mt-4">
        <ul class="pagination">
            <li class="page-item {{ $Roles->currentPage() == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $Roles->appends(request()->except('page'))->url(1) }}">Primera</a>
            </li>
            @for ($page = max(1, $Roles->currentPage() - 2); $page <= min($Roles->lastPage(), $Roles->currentPage() + 2); $page++)
                <li class="page-item {{ $page == $Roles->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $Roles->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                </li>
            @endfor
            <li class="page-item {{ $Roles->currentPage() == $Roles->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $Roles->appends(request()->except('page'))->url($Roles->lastPage()) }}">Última</a>
            </li>
        </ul>
    </div>
</div>
@include('fooder')
</body>
</html>
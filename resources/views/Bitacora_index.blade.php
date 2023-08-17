<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Entradas en la Bitácora</title>
    @include('link')
    <style>
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
@include('menu')
<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Entradas en la Bitácora</h2>
    <form action="{{ route('bitacora.filter') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <h3>Busqueda</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="usuario" id="usuario" placeholder="Por Usuario" class="form-control" @if(request()->filled('usuario')) value="{{ request()->input('usuario') }}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="num_tiquete" id="num_tiquete" placeholder="Por Numero Tiquete" class="form-control" @if(request()->filled('num_tiquete')) value="{{ request()->input('num_tiquete') }}" @endif>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-group d-flex">
                    <?php
                        $user = auth()->user();
                        if ($user && $user->rol) {
                            $permisoAgregar = $user->rol->permisos()->where('idOperacion', 13)->exists();
                            $permisoEliminar = $user->rol->permisos()->where('idOperacion', 13)->exists();
                        } else {
                            $permisoAgregar = $permisoEliminar = false;
                        }
                    ?>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('Bitacora_index') }}" class="btn btn-secondary ml-2">
                        <i class="bi bi-arrow-counterclockwise"></i> Limpiar filtro
                    </a>
                    @if ($permisoAgregar)
                    <a href="{{ route('Agregar_bitacora')}}" class="btn btn-success ml-2">
                        <i class="bi bi-person-plus"></i> Agregar Bitacora
                    </a>
                    @endif
                    <a href="{{ route('bitacoras.pdf',[ 'usuario' => request('usuario'), 'num_tiquete' => request('num_tiquete')]) }}" class="btn btn-info ml-2">
                        <i class="bi bi-printer-fill"></i>Generar Reporte
                    </a>
                </div>
            </div>
        </div>
    </form>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Número de Tiquete</th>
                <th>Usuario Revisor</th>
                <th>Comentario</th>
                <th>Fecha y Hora del Comentario</th>
                @if ($permisoEliminar)
                <th>Eliminar</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($bitacoras as $bitacora)
            <tr>
                <td>{{ $bitacora->num_tiquete }}</td>
                <td>{{ $bitacora->usuario }}</td>
                <td>{{ $bitacora->comentario }}</td>
                <td>{{ $bitacora->fecha_hora }}</td>
                @if ($permisoEliminar)
                <td><form action="{{ route('bitacora.destroy', $bitacora->id_bitacora) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</button>
                </form></td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination justify-content-center mt-4">
        <ul class="pagination">
            <li class="page-item {{ $bitacoras->currentPage() == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $bitacoras->appends(request()->except('page'))->url(1) }}">Primera</a>
            </li>
            @for ($page = max(1, $bitacoras->currentPage() - 2); $page <= min($bitacoras->lastPage(), $bitacoras->currentPage() + 2); $page++)
                <li class="page-item {{ $page == $bitacoras->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $bitacoras->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                </li>
            @endfor
            <li class="page-item {{ $bitacoras->currentPage() == $bitacoras->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $bitacoras->appends(request()->except('page'))->url($bitacoras->lastPage()) }}">Última</a>
            </li>
        </ul>
    </div>
</div>
@include('fooder')
</body>
</html>
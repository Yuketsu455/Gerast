<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tiquetes - Lista</title>
    @include('link')
</head>
<body>
@include('menu')
<div class="container mt-5 ">
    <h2 class="text-center mb-4">Tiquetes</h2>
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
    <div class="container">
        <h4>Busqueda Por</h4>
        <form action="{{ route('tiquetes.filter') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="num_caso">Número de Caso:</label>
                        <input type="text" name="num_caso" id="num_caso" class="form-control" value="{{ request()->input('num_caso') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="id_cliente">ID de Cliente:</label>
                        <input type="text" name="id_cliente" id="id_cliente" class="form-control" value="{{ request()->input('id_cliente') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" value="{{ request()->input('usuario') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="prioridad">Prioridad:</label>
                        <select name="prioridad" id="prioridad" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="Alta" @if(request()->input('prioridad') === 'Alta') selected @endif>Alta</option>
                            <option value="Media" @if(request()->input('prioridad') === 'Media') selected @endif>Media</option>
                            <option value="Baja" @if(request()->input('prioridad') === 'Baja') selected @endif>Baja</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="Recibido" @if(request()->input('estado') === 'Recibido') selected @endif>Recibido</option>
                            <option value="En Revision" @if(request()->input('estado') === 'En Revision') selected @endif>En Revisión</option>
                            <option value="Confirmacion Pendiente" @if(request()->input('estado') === 'Confirmacion Pendiente') selected @endif>Confirmación Pendiente</option>
                            <option value="Servicio" @if(request()->input('estado') === 'Servicio') selected @endif>Servicio</option>
                            <option value="Listo" @if(request()->input('estado') === 'Listo') selected @endif>Listo</option>
                            <option value="Entregado" @if(request()->input('estado') === 'Entregado') selected @endif>Entregado</option>
                            <option value="Cerrado" @if(request()->input('estado') === 'Cerrado') selected @endif>Cerrado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-group d-flex">
                        <?php
                        $user = auth()->user();
                        if ($user && $user->rol) {
                            $permisoAgregar = $user->rol->permisos()->where('idOperacion', 9)->exists();
                            $permisoEditar = $user->rol->permisos()->where('idOperacion', 10)->exists();
                            $permisoEliminar = $user->rol->permisos()->where('idOperacion', 11)->exists();
                        } else {
                            $permisoAgregar = $permisoEditar = $permisoEliminar = false;
                        }
                    ?>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter"></i> Filtrar
                        </button>
                        <a href="{{ route('Tiquete_index') }}" class="btn btn-secondary ml-2">
                            <i class="bi bi-arrow-counterclockwise"></i> Limpiar filtro
                        </a>
                        @if ($permisoAgregar)
                        <a href="{{ route('Agregar_Tiquete')}}" class="btn btn-success ml-2">
                            <i class="bi bi-person-plus"></i> Agregar Tiquete
                        </a>
                        @endif
                        <a href="{{ route('tiquetes.pdf',[ 'num_caso' => request('num_caso'), 'id_cliente' => request('id_cliente'),'usuario' => request('usuario')
                        ,'prioridad' => request('prioridad'),'estado' => request('estado')]) }}" class="btn btn-info ml-2">
                            <i class="bi bi-printer-fill"></i> Generar Reporte
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    @if ($permisoEditar)
                    <th>Actualizar</th>
                    @endif
                    @if ($permisoEliminar)
                    <th>Eliminar</th>
                    @endif
                    <th>Número de Caso</th>
                    <th>Tipo de Equipo</th>
                    <th>Identificación del Cliente</th>
                    <th>Usuario Recibe</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Cargador</th>
                    <th>Garantía</th>
                    <th>Fecha y Hora de Ingreso</th>
                    <th>Prioridad</th>
                    <th>Estado del Tiquete</th>
                    <th>Fotografias</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $Tiquetes as $tiquete)
                <tr>
                    @if ($permisoEditar)
                    <td><a href="{{ route('Tiquete_editar', ['num_caso' => $tiquete->num_caso]) }}" role="button" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Actualizar</a></td>
                    @endif
                    @if ($permisoEliminar)
                    <td>
                        <a href="{{ route('eliminar_tiquete', ['num_caso' => $tiquete->num_caso]) }}" role="button" onclick="event.preventDefault();
                            if (confirm('¿Estás seguro de eliminar este tiquete?')) {
                                document.getElementById('eliminar-form-{{ $tiquete->num_caso }}').submit();
                            }" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i>Eliminar</a>
                        <form id="eliminar-form-{{ $tiquete->num_caso }}" action="{{ route('eliminar_tiquete', ['num_caso' => $tiquete->num_caso]) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                    @endif
                    <td>{{ $tiquete->num_caso }}</td>
                    <td>{{ $tiquete->tipo_equipo }}</td>
                    <td>{{ $tiquete->id_cliente}}</td>
                    <td>{{ $tiquete->usuario }}</td>
                    <td>{{ $tiquete->marca }}</td>
                    <td>{{ $tiquete->modelo }}</td>
                    <td>{{ $tiquete->serie }}</td>
                    <td>{{ $tiquete->cargador }}</td>
                    <td>{{ $tiquete->garantia }}</td>
                    <td>{{ $tiquete->fecha }}</td>
                    <td>{{ $tiquete->prioridad }}</td>
                    <td>{{ $tiquete->estado_tiquete }}</td>
                    <td>{{ $tiquete->fotografia }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div class="pagination justify-content-center mt-4">
            <ul class="pagination">
                <li class="page-item {{ $Tiquetes->currentPage() == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $Tiquetes->appends(request()->except('page'))->url(1) }}">Primera</a>
                </li>
                @for ($page = max(1, $Tiquetes->currentPage() - 2); $page <= min($Tiquetes->lastPage(), $Tiquetes->currentPage() + 2); $page++)
                    <li class="page-item {{ $page == $Tiquetes->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $Tiquetes->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $Tiquetes->currentPage() == $Tiquetes->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $Tiquetes->appends(request()->except('page'))->url($Tiquetes->lastPage()) }}">Última</a>
                </li>
            </ul>
        </div>
      
    </div>
@include('fooder')
</body>
</html>
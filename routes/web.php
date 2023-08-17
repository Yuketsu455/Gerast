<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TiqueteController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngresosController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\MovimientosPDFController;
use App\Http\Controllers\PDFClientesController;
use App\Http\Controllers\PDFBitacoraController;
use App\Http\Controllers\PDFTiquetesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Validacion de login y invocacion del proceso
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('login');
});

//Paso al index

Route::get('welcome', function () {
    return view('welcome');
})->name('welcome');

    // Rutas de Bitácoras
    Route::get('Bitacora_index', function () {
        return view('Bitacora_index');
    })->name('Bitacora_index')->middleware('permission:14');

    Route::get('Agregar_bitacora', function () {
        return view('Agregar_bitacora');
    })->name('Agregar_bitacora')->middleware('permission:13');

    Route::get('/mostrar-tiquetes', [BitacoraController::class, 'mostrarTiquetes'])->name('Agregar_bitacora')->middleware('permission:13');
    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('Bitacora_index')->middleware('permission:14');
    Route::post('/bitacora', [BitacoraController::class, 'store'])->name('bitacora.store');
    Route::post('/bitacora/filter', [BitacoraController::class, 'filter'])->name('bitacora.filter')->middleware('permission:13');
    Route::match(['get', 'post'], '/bitacora/filter', [BitacoraController::class, 'filter'])->name('bitacora.filter')->middleware('permission:13');
    Route::get('/bitacoraPDF', [PDFBitacoraController::class, 'generarPDF'])->name('bitacoras.pdf')->middleware('permission:14');
    Route::delete('/bitacora/{id_bitacora}', [BitacoraController::class, 'destroy'])->name('bitacora.destroy')->middleware('permission:13');
    // Rutas de Clientes
    Route::get('Cliente_index', function () {
        return view('Cliente_index');
    })->name('Cliente_index')->middleware('permission:8');

    Route::get('Agregar_cliente', function () {
        return view('Agregar_cliente');
    })->name('Agregar_cliente')->middleware('permission:5');

    Route::get('Cliente_editar', function () {
        return view('Cliente_editar');
    })->name('Cliente_editar')->middleware('permission:6');

    Route::get('/cliente', [ClienteController::class, 'index'])->name('Cliente_index')->middleware('permission:8');
    Route::post('/cliente', [ClienteController::class, 'store'])->name('cliente.store')->middleware('permission:5');
    Route::get('/cliente/{cedula}/editar', [ClienteController::class, 'edit'])->name('Cliente_editar')->middleware('permission:6');
    Route::post('/cliente/{cedula}/update', [ClienteController::class, 'update'])->name('cliente.update');
    Route::delete('/clientes/{cedula}', [ClienteController::class, 'destroy'])->name('eliminar_cliente')->middleware('permission:7');
    Route::match(['get', 'post'], '/clientes/filter', [ClienteController::class, 'filter'])->name('clientes.filter')->middleware('permission:8');
    Route::get('/clientesPDF', [PDFClientesController::class, 'generarPDF'])->name('clientes.pdf')->middleware('permission:8');
    // Rutas de Tiquetes
    Route::get('Tiquete_index', function () {
        return view('Tiquete_index');
    })->name('Tiquete_index')->middleware('permission:12');

    Route::get('Agregar_Tiquete', function () {
        return view('Agregar_Tiquete');
    })->name('Agregar_Tiquete')->middleware('permission:9');

    Route::get('Tiquete_editar', function () { 
        return view('Tiquete_editar');
    })->name('Tiquete_editar')->middleware('permission:10');

    Route::get('/tiquete', [TiqueteController::class, 'index'])->name('Tiquete_index')->middleware('permission:12');
    Route::post('/tiquete', [TiqueteController::class, 'store'])->name('tiquete.store')->middleware('permission:9');
    Route::get('/tiquete/Agregar_Tiquete', [TiqueteController::class, 'mostrarFormulario'])->name('Agregar_Tiquete')->middleware('permission:9');
    Route::get('/tiquete/{num_caso}/editar', [TiqueteController::class, 'edit'])->name('Tiquete_editar')->middleware('permission:10');
    Route::post('/tiquete/{num_caso}/update', [TiqueteController::class, 'update'])->name('tiquete.update');
    Route::delete('/tiquete/{num_caso}', [TiqueteController::class, 'destroy'])->name('eliminar_tiquete')->middleware('permission:11');
    Route::match(['get', 'post'], '/tiquete/filter', [TiqueteController::class, 'filter'])->name('tiquetes.filter')->middleware('permission:12');
    Route::get('/tiquetesPDF', [PDFTiquetesController::class, 'generarPDF'])->name('tiquetes.pdf')->middleware('permission:12');
    // Rutas de Usuarios
    Route::get('Usuarios_index', function () {
        return view('Usuarios_index');
    })->name('Usuarios_index')->middleware('permission:4');

    Route::get('Agregar_Usuario', function () {
        return view('Agregar_Usuario');
    })->name('Agregar_Usuario')->middleware('permission:1');

    Route::get('Usuario_editar', function () {
        return view('Usuario_editar');
    })->name('Usuario_editar')->middleware('permission:2');

    Route::get('/usuario', [UsuarioController::class, 'index'])->name('Usuario_index')->middleware('permission:4');
    Route::post('/usuario', [UsuarioController::class, 'store'])->name('usuario.store')->middleware('permission:1');
    Route::get('/usuario/Agregar_Usuario', [UsuarioController::class, 'mostrarRoles'])->name('Agregar_Usuario')->middleware('permission:1');
    Route::get('/usuario/{cedula}/editar', [UsuarioController::class, 'edit'])->name('Usuario_editar')->middleware('permission:2');
    Route::post('/usuario/{cedula}/update', [UsuarioController::class, 'update'])->name('usuario.update')->middleware('permission:2');
    Route::put('/usuario/{cedula}/deshabilitar', [UsuarioController::class, 'deshabilitarUsuario'])->name('usuario.deshabilitar')->middleware('permission:3');
    Route::put('/usuario/{cedula}/habilitar', [UsuarioController::class, 'habilitarUsuario'])->name('usuario.habilitar')->middleware('permission:3');
    Route::match(['get', 'post'], '/usuario/filter', [UsuarioController::class, 'filter'])->name('usuarios.filter')->middleware('permission:4');
    // Rutas de Roles
    Route::get('Roles_index', function () {
        return view('Roles_index');
    })->name('Roles_index')->middleware('permission:18');

    Route::get('Agregar_Rol', function () {
        return view('Agregar_Rol');
    })->name('Agregar_Rol')->middleware('permission:15');

    Route::get('/roles', [RolesController::class, 'index'])->name('Roles_index')->middleware('permission:18');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store')->middleware('permission:15');
    Route::get('/roles/{id}/permisos', [RolesController::class, 'asignarPermisos'])->name('roles.permisos')->middleware('permission:16');
    Route::post('/roles/{id}/permisos', [RolesController::class, 'guardarPermisos'])->name('roles.guardar_permisos')->middleware('permission:16');
    Route::delete('roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy')->middleware('permission:16');
    Route::match(['get', 'post'], '/roles/filter', [RolesController::class, 'filter'])->name('roles.filter')->middleware('permission:18');
    
//RUTAS INGRESOS
Route::match(['get', 'post'], '/ingresos/filter', [IngresosController::class, 'filter'])->name('ingresos.filter')->middleware('permission:19');
Route::get('/ingresos', [IngresosController::class, 'index'])->name('Ingresos_index')->middleware('permission:19');
Route::get('/pdf', [PDFController::class, 'generarPDF'])->name('pdf')->middleware('permission:19');

//RUTAS MOVIMIENTOS
Route::get('/movimientos', [MovimientosController::class, 'index'])->name('Movimientos_index')->middleware('permission:20');
Route::match(['get', 'post'], '/movimientos/filter', [MovimientosController::class, 'filter'])->name('movimientos.filter')->middleware('permission:4');
Route::get('/movimientopdf', [MovimientosPDFController::class, 'generarPDF'])->name('movimientos.pdf')->middleware('permission:20');
//Ruta de Acerca De
Route::get('Acercade', function () {
    return view('Acercade');
})->name('Acercade');


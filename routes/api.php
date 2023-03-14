<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\PrestadorController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ImagensController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AgendamentoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Cadastro Controller ====================================================
Route::post('/signup',[CadastroController::class,'signUp']);
Route::post('/signup2',[CadastroController::class,'cadastraPrestador']);
// Login Controller ====================================================
Route::post('/login',[LoginController::class,'signIn']);
Route::post('/loginAdmin',[LoginController::class,'signInAdmin']);
// Cidade Controller ====================================================
Route::post('/cidade', [CidadeController::class, 'get']);
Route::get('/cidade/{id}', [CidadeController::class, 'getById']);
Route::post('/cidade/{id}/update', [CidadeController::class, 'update']);    // restrita admin
Route::get('/cidades', [CidadeController::class, 'list']);
Route::post('/cidades', [CidadeController::class, 'add']); // restrita admin
// Categoria Controller ================================================
Route::get('/categorias', [CategoriaController::class, 'list']);
Route::post('/categorias', [CategoriaController::class, 'add']); // restrita admin
Route::get('/categoria/{id}', [CategoriaController::class, 'getById']);
Route::post('/categoria/{id}/update', [CategoriaController::class, 'update']); // restrita admin
// Subcategoria Controller ==============================================
Route::get('/subcategorias', [SubcategoriaController::class, 'list']);
Route::post('/subcategorias', [SubcategoriaController::class, 'add']); // restrita admin
Route::get('/subcategoria/{id}', [SubcategoriaController::class, 'getById']);
Route::post('/subcategoria/{id}/update', [SubcategoriaController::class, 'update']); // restrita admin
// Prestadores Controller ===================================================
Route::get('/prestadores', [PrestadorController::class, 'list']);
Route::post('/prestadores', [PrestadorController::class, 'add']); // restrita admin
Route::get('/prestador/{id}', [PrestadorController::class, 'getById']);
Route::post('/prestador/{id}/update', [PrestadorController::class, 'update']); // restrita admin
// Serviços Controller =====================================================
Route::get('/servicos', [ServicoController::class, 'list']);
Route::post('/servicos', [ServicoController::class, 'add']); // restrita admin
Route::get('/servico/{id}', [ServicoController::class, 'getById']);
Route::post('/servico/{id}/update', [ServicoController::class, 'update']); // restrita admin
Route::post('/seed', [ServicoController::class, 'seed']);
Route::post('/geo', [ServicoController::class, 'getCityByCoords']);
// Imagens Controller =====================================================
Route::post('/imagens', [ImagensController::class, 'add']); // restrita admin
Route::get('/imagens/{idServico}', [ImagensController::class, 'listByServico']);
Route::post('/imagens/delete/{id}', [ImagensController::class, 'delete']); // restrita admin
// Reviews Controller =====================================================
Route::get('/reviews/{idServico}', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::delete('/reviews/{id}', [HorariosController::class, 'destroy']);
// Horarios Controller =====================================================
Route::post('/horarios', [HorariosController::class, 'add']); // restrita admin e prestador
Route::get('/horarios/{idServico}', [HorariosController::class, 'index']);
Route::get('/horarios/disponiveis/{idServico}', [HorariosController::class, 'index2']);
Route::delete('/horarios/{id}', [HorariosController::class, 'destroy']);
//Route::get('/horarios/{idServico}/{data}', [HorariosController::class, 'listByDay']);
// Users Controller =====================================================
Route::get('/usuarios/prestadores',[UserController::class,'ListPrestadores']);
Route::get('/usuarios/clientes',[UserController::class,'ListClientes']);
Route::get('/usuario/{id}',[UserController::class,'getById']);
Route::post('usuario/update/{id}',[UserController::class,'updateUsuario']);
Route::post('usuario/updatepassword/{id}',[UserController::class,'trocaSenhaUsuario']);
// Agendamento Controller =====================================================
Route::post('/agendamentos', [AgendamentoController::class, 'store']);
Route::get('/agendamentos', [AgendamentoController::class, 'index']);
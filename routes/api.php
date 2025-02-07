<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Acesso com auth
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Retornando informações direto no get
// Route::get('/user', function (Request $request) {
//     return response()->json([
//         'status' => true,
//         'message' => 'Listar Usuários'
//     ], 200);
// });

// Rota pública

Route::get('/users', [UserController::class, 'getForApiUserAll']);  // GET - http://127.0.0.1:8000/api/users?page=1
Route::get('/users/{user}', [UserController::class, 'getForApiUser']); // GET - http://127.0.0.1:8000/api/users/1
Route::post('/users', [UserController::class, 'storeForApiUser']);// POST - http://127.0.0.1:8000/api/users
Route::put('/users/{user}', [UserController::class, 'putForApiUser']); // PUT - http://127.0.0.1:8000/api/users/1
Route::delete('/users/{user}', [UserController::class, 'deleteForApiUser']); // DELETE - http://127.0.0.1:8000/api/users/1

// Route::post('/', [LogiAPInController::class, 'login'])->name('login'); // POST - http://127.0.0.1:8000/api/ - { "email": "cesar@celke.com.br", "password": "123456a" }
// Rota restrita
Route::group(['middleware' => ['auth:sanctum']], function(){
    // Route::post('/logout/{user}', [LogiAPInController::class, 'logout']); // POST - http://127.0.0.1:8000/api/logout/1
});

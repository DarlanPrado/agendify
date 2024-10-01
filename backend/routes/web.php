<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::prefix('api')->group(function () {
    // Listar todos os contatos
    Route::get('/contacts', [ContactController::class, 'index']);
    
    // // Obter um contato específico
    // Route::get('/contacts/{id}', [ContactController::class, 'show']);
    
    // // Criar um novo contato
    // Route::post('/contacts', [ContactController::class, 'store']);
    
    // // Atualizar um contato existente
    // Route::put('/contacts/{id}', [ContactController::class, 'update']);
    
    // // Deletar um contato
    // Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
});
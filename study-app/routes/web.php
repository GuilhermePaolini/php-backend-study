<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\CredentialsController;
use App\Models\Pokemon;

Route::get("/populate_db", function () {
    set_time_limit(0);
    for ($i = 1; $i <= 1051; $i++) {
        $id = $i;
        $url = 'https://pokeapi.co/api/v2/pokemon/' . $id;
        $response = file_get_contents($url);
        $response = json_decode($response, true);
    
        Pokemon::updateOrCreate(
            ['id' => $id],
            [
                'name' => $response['name'],
                'base_experience' => $response['base_experience'],
                'height' => $response['height'],
                'weight' => $response['weight'],
                'abilities' => $response['abilities'],
                'cries' => $response['cries'],
                'forms' => $response['forms'],
                'game_indices' => $response['game_indices'],
                'held_items' => $response['held_items'],
                'moves' => $response['moves'],
                'sprites' => $response['sprites'],
                'stats' => $response['stats'],
                'types' => $response['types'],
            ]
        );
    }
    
    return response()->json(['message' => 'Database populated successfully']);
});

Route::get('/login', function () {
    return 'Login Page';
})->name('login');

Route::post('/credentials/register', [CredentialsController::class, 'register']);
Route::post('/credentials/login', [CredentialsController::class, 'login']);

Route::post('/api/pokemon', [PokemonController::class, 'getPokemon']);
Route::middleware('auth')->post('/api/pokemon/add_to_collection', [PokemonController::class, 'addToCollection']);
Route::middleware('auth')->get('/api/pokemon/check', [PokemonController::class, 'checkCollection']);
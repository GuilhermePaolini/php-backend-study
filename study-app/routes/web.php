<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/login', function () {
    return 'Login Page';
})->name('login');

Route::post('/credentials/register', function () {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validação básica (opcional)
    if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
        return response()->json(['error' => 'Invalid input'], 400);
    }

    // Cria um novo usuário e salva no banco de dados
    $user = new User();
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->password = bcrypt($data['password']); // Use bcrypt para criptografar a senha
    $user->save();

    return response()->json(['message' => 'User registered successfully']);
});

Route::post('/credentials/login', function () {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validação básica
    if (!isset($data['email']) || !isset($data['password'])) {
        return response()->json(['error' => 'Invalid input'], 400);
    }

    // Verifica as credenciais do usuário
    if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
        // Gera o token CSRF
        $csrfToken = csrf_token();
        return response()->json(['message' => 'Login successful', 'csrf_token' => $csrfToken]);
    } else {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
});

Route::post('/api/pokemon', function () {
    // Recebe a solicitação POST do front (assumimos que este é um front selado, sem possibilidade de injeção de código)
    $json = file_get_contents('php://input');
    // Decodifica o json recebido e pega o valor da chave 'name'
    $name = json_decode($json)->name;
    Log::info('json decodificado');
    // Monta a URL da API de acordo com o nome do pokemon (assumimos que não receberá nomes não existentes)
    $url = 'https://pokeapi.co/api/v2/pokemon/' . $name;
    Log::info('url montada');

    // Faz a requisição GET para a API do pokemon
    $response = file_get_contents($url);
    Log::info('get feito: ' . $response);

    // Trata o json recebido para devolver ao front
    $response = json_decode($response);
    Log::info('json decodificado');
    
    // Como types pode ser mais de 1 mas nem sempre, explodimos o array em strings usando name
    $types = array_map(function($type) {
        return $type->type->name;
    }, $response->types);

    $typesString = implode(', ', $types);

    $data = [
        'name' => $response->name,
        'weight' => $response->weight,
        'types' => $typesString
    ];
    Log::info('Dados retornados: ' . json_encode($data));
    return response()->json($data);
});

Route::middleware('auth')->post('/api/pokemon/add_to_collection', function () {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!isset($data['name'])) {
        return response()->json(['error' => 'Invalid input'], 400);
    }

    $user = Auth::user();

    $pokemons = $user->pokemons;
    if (isset($pokemons[$data['name']])) {
        $pokemons[$data['name']] = true;
    } else {
        return response()->json(['error' => 'Pokemon not found'], 404);
    }

    $user->pokemons = $pokemons;
    $user->save();

    return response()->json(['message' => 'Collection updated successfully']);
    
});

Route::middleware('auth')->get('/api/pokemon/check', function () {
    $user = Auth::user();
    $data = $user->pokemons;

    // Extrai as chaves onde os valores são false
    $falseKeys = array_keys(array_filter($data, function ($value) {
        return $value === false;
    }));

    return response()->json(['false_keys' => $falseKeys]);
});
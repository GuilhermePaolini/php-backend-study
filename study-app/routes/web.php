<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;



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

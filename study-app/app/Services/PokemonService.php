<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Pokemon;

class PokemonService
{
    public function getPokemonData($name)
    {
        $url = 'https://pokeapi.co/api/v2/pokemon/' . $name;
        $response = file_get_contents($url);
        $response = json_decode($response);

        $types = array_map(function($type) {
            return $type->type->name;
        }, $response->types);

        $typesString = implode(', ', $types);

        return [
            'name' => $response->name,
            'weight' => $response->weight,
            'types' => $typesString
        ];
    }

    public function addToCollection($pokemons)
    {
        $user = Auth::user();
        foreach ($pokemons as $pokemon) {
            if (!Pokemon::where('name', $pokemon)->first()) {
                return ['error' => 'Pokemon not found', 'status' => 404];
            }
            $user->pokemons()->attach($pokemon->id);
        }
        
        return ['message' => 'Collection updated successfully', 'status' => 200];
    }

    public function checkCollection()
    {
        $user = Auth::user();
        $pokemons = $user->pokemons()->pluck('name')->toArray();

        return $pokemons;
    }
}
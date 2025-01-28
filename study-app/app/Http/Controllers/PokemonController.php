<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PokemonService;

class PokemonController extends Controller
{
    protected $pokemonService;

    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }

    public function getPokemon(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];

        $pokemonData = $this->pokemonService->getPokemonData($name);

        return response()->json($pokemonData);
    }

    public function addToCollection(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];

        $result = $this->pokemonService->addToCollection($name);

        return response()->json(['message' => $result['message']], $result['status']);
    }

    public function checkCollection()
    {
        $pokemons = $this->pokemonService->checkCollection();

        return response()->json(['pokemons' => $pokemons]);
    }
}
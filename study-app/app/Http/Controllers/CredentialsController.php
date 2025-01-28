<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CredentialsService;

class CredentialsController extends Controller
{
    protected $credentialsService;

    public function __construct(CredentialsService $credentialsService)
    {
        $this->credentialsService = $credentialsService;
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $result = $this->credentialsService->register($data);

        return response()->json(['message' => $result['message']], $result['status']);
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $result = $this->credentialsService->login($data);

        return response()->json($result, $result['status']);
    }
}

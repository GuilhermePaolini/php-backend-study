<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CredentialsService
{
    public function register(array $data)
    {
        // Basic validation (optional)
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
            return ['error' => 'Invalid input', 'status' => 400];
        }

        // Create a new user and save to the database
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']); // Use bcrypt to encrypt the password
        $user->save();

        return ['message' => 'User registered successfully', 'status' => 200];
    }

    public function login(array $data)
    {
        // Basic validation
        if (!isset($data['email']) || !isset($data['password'])) {
            return ['error' => 'Invalid input', 'status' => 400];
        }

        // Check user credentials
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            // Generate CSRF token
            $csrfToken = csrf_token();
            return ['message' => 'Login successful', 'csrf_token' => $csrfToken, 'status' => 200];
        } else {
            return ['error' => 'Invalid credentials', 'status' => 401];
        }
    }
}
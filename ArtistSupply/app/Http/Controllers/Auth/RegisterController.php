<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); 
    }

    public function register(Request $request)
    {
        // Certifique-se de que todos os campos foram preenchidos
        if (!$request->name || !$request->email || !$request->phone || !$request->password) {
            return redirect()->back()
                ->with('error', 'Todos os campos são obrigatórios.')
                ->withInput();
        }
    
        // Verificar se o email já está em uso
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()
                ->with('error', 'O email já está em uso.')
                ->withInput();
        }
    
        // Criar o usuário com a senha hasheada
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocorreu um erro ao cadastrar: ' . $e->getMessage())
                ->withInput();
        }
    
        return redirect()->route('login')->with('success', 'Conta criada com sucesso! Faça login.');
    }
    
    
}

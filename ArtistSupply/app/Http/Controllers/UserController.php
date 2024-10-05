<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\User;

class UserController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function edit()
    { 
        $user = Auth::user();  
        return view('users.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();  

        \DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string'
            ]);

            $user->name = $validatedData['name'];
            $user->phone = $validatedData['phone'];
            $user->email = $validatedData['email'];

            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();  

            }catch(\Exception $e){
                \DB::rollBack();
                Session::flash('error', 'Erro ao atualizar, tente novamente mais tarde.');
                return redirect()->back();
            }

            \DB::commit();

            Session::flash('success', 'Usuário atualizado com sucesso!');
            return redirect()->back();
    }


    public function destroy()
    {
        $user = Auth::user();  
        
        User::where('id', $user->id)->delete();

        return redirect('/')->with('success', 'Usuário deletado com sucesso.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Event;
use App\Models\User;

class UserController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        $products = Product::where('user_id', $user->id)
                            ->orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();

        $events = Event::where('user_id', $user->id)
                        ->orderBy('data_inicio', 'desc')
                        ->take(3)
                        ->get();

        return response()->json([
            'user' => $user,
            'products' => $products,
            'events' => $events,
        ], 200);
    }

    public function edit()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user,
        ], 200);
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

            \DB::commit();

            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'user' => $user,
            ], 200);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'error' => 'Erro ao atualizar, tente novamente mais tarde.',
            ], 500);
        }
    }

    public function destroy()
    {
        $user = Auth::user();

        User::where('id', $user->id)->delete();

        return response()->json([
            'message' => 'Usuário deletado com sucesso.',
        ], 200);
    }
}

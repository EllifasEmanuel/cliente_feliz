<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function criarUsuario($data){
        DB::beginTransaction();
        try{
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['senha'])
            ]);
            DB::commit();
            return response()->json([
                'error' => false,
                'message' => "Usuário criado com sucesso.",
            ]);
        }catch(\Throwable $e){
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function atualizarUsuario($data){
        DB::beginTransaction();
        try{
            $user = User::find($data['user_id']);            
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['senha']);
            $user = $user->save();
            DB::commit();
            return response()->json([
                'error' => false,
                'message' => "Usuário atualizado com sucesso.",
            ]);
        }catch(\Throwable $e){
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deletarUsuario($user){
        DB::beginTransaction();
        try{
            $user->delete();
            DB::commit();
            return response()->json([
                'error' => false,
                'message' => "Usuário excluído com sucesso.",
            ]);
        }catch(\Throwable $e){
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
    
}
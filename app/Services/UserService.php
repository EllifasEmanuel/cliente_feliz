<?php

namespace App\Services;

use App\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService{
    protected UserRepository $repository;

    public function __construct()
    {
        $this->repository = app(UserRepository::class);
    }

    public function criarUsuario($data){
        if($this->verificarUsuario($data['user_email'])){
            return response()->json([
                'error' => true,
                'message' => 'Usuário existente.'
            ]);
        }
        return $this->repository->criarUsuario($data);
    }

    public function atualizarUsuario($data){
        if(!$this->verificarUsuario($data['user_email'])){
            return response()->json([
                'error' => true,
                'message' => 'Usuário não existe.'
            ]);
        }
        return $this->repository->atualizarUsuario($data);
    }

    public function deletarUsuario($data){
        $user = User::find($data['user_id']);
        if(!$user){
            return response()->json([
                'error' => true,
                'message' => 'Usuário não encontrado.'
            ]);
        }
        return $this->repository->deletarUsuario($user);
    }

    private function verificarUsuario($email){
        if(User::where('email', $email)->exists()){
            return true;
        }
        return false;
    }

}
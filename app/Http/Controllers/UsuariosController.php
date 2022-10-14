<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    protected UserService $service;

    public function __construct(){
        $this->service = app(UserService::class);
    }

    public function index(){
        return view('layouts.usuarios');
    }

    public function show(){
        $usuarios = User::select('id','name','email');

        return datatables($usuarios)->make(true);
    }

    public function create(Request $request){
        return $this->service->criarUsuario($request);
    }

    public function update(Request $request){
        return $this->service->atualizarUsuario($request);
    }

    public function remove(Request $request){
        return $this->service->deletarUsuario($request);
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function index(){
        return view('layouts.usuarios');
    }

    public function show(){
        
        $usuarios = User::select('id','name');

        return datatables($usuarios)->make(true);
    }

    public function update(Request $request){
        $usuarios = User::find($request['user_id']);
        // User::select('id','name');

        return response()->json($request);
    }

    public function remove(Request $request){
        $usuarios = User::find($request['user_id']);
        // User::select('id','name');

        return response()->json($request);
    }
}

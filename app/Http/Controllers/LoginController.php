<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function destroy(){
        Auth::logout();

        return redirect('login');
    }
}
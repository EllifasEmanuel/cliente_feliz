<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PDF;

class ExportPDFController extends Controller
{
    public function generatePDF()
    {
        $usuarios = User::all();
        $pdf = PDF::loadView('pdf.usuarios',[
            'users' => $usuarios
        ]);
        
        return $pdf->download('usuarios.pdf');
    }
}
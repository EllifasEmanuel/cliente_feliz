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
        $pdf = PDF::loadView('pdf.usuarios');
        
        return $pdf->download('users.pdf');
    }
}
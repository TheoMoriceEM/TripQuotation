<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WebController extends Controller
{
    public function quotationForm(): View
    {
        return view('quotation-form');
    }
}

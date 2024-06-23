<?php

namespace App\Http\Controllers\Mantra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GateController extends Controller
{
    public function list()
    {
        return view('mantra.greetings.list');
    }
}

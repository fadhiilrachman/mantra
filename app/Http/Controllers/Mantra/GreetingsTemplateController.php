<?php

namespace App\Http\Controllers\Mantra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GreetingsTemplateController extends Controller
{
    public function create()
    {
        return view('mantra.greetings.create');
    }

    public function list()
    {
        return view('mantra.greetings.list');
    }
}

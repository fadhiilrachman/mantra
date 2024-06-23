<?php

namespace App\Http\Controllers\Mantra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function activeNumbers()
    {
        return view('mantra.reports.activenumbers');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $leads=Lead::count();

        return view('admin.reports.index');
    }
}

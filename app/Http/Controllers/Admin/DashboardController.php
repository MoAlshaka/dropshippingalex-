<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $leads = Lead::count();
        $approvedLeadsCount = Lead::where('status', 'approved')->count();
        $deliveredLeadsCount = Lead::where('seller_id', auth()->guard('seller')->id())->where('status', 'delivered')->count();

        return view('admin.dashboard');
    }
}

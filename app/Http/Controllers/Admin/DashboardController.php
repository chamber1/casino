<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

/**
 * Admin panel Main Dashboard Controller
 *
 * @author Yurii Yurenko <yurenkoyura@gmail.com>
 */
class DashboardController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        
       return view('admin/layouts/dashboard');   
    }
}

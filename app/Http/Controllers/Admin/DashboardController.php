<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

/**
 * Description of DashboardController
 *
 * @author yuren
 */
class DashboardController extends Controller{
    
    
    public function __construct()
    {
        $this->middleware('auth');
      
        
    }
    
    public function index() {
        
       // View::share('current_user', Auth::User());
        
        return view('admin/layouts/dashboard');   
        
    }


//put your code here
}

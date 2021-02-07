<?php
namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Admin Panel Clients Controller
 *
 * @author Yuriy Yurenko <yurenkoyura@gmail.com>
 */
class ClientController extends Controller{
    
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {

        return view('admin/client/index');   
    }
    
    /**
     * Get All Clients.
     * 
     *
     * @return DataTables object
     */
    public function data() {
        
        $tables = Client::select(['id', 'name','phone']);
     
        return DataTables::of($tables)
            ->addColumn('action', function (Client $tables) {
                $html = '<a href="' . URL::to('admin/client/' . $tables->id . '/edit') 
                    . '" class="btn btn btn-primary btn-sm btn-sm-table">'
                    . '<i class="fa fa-edit"></i>Show</a>&nbsp;&nbsp;&nbsp;';
                
                return $html;
            })
            ->removeColumn('id')
            ->make(true);
    }
    
    /**
     * Create client form.
     * 
     *
     * @return view
     */
    public function create()
    {
        return view('admin.client.create');
    }
    
    /**
     * Edit client form.
     * 
     *
     * @return view
     */
    public function edit(Request $request,Client $client)
    {   
        return view('admin.client.edit',compact('client'));
    }
    
    /**
     * Update client.
     * 
     * @param ClientRequest $request
     * @param Client $client Model
     *
     * @return Redirect on New client created
     */
    public function update(ClientRequest $request,Client $client)
    {
        $client->name = $request->input('name');
        $client->phone = $request->input('phone');
        
        if ($client->update()) {
           return redirect()->back()->withSuccess('Record updated');;
        } 
    }
    
    /**
     * Store a newly created client.
     * 
     * @param ClientRequest $request
     *
     * @return Redirect on New client created
     */
    public function store(ClientRequest $request)
    {
        $client = new Client();
        $client->name = $request->input('name');
        $client->phone = $request->input('phone');
        $password = $request->input('password');
        $client->password = Hash::make($password);
        $client->save();

        if ($client->id) {
            
            return redirect('admin/client/'.$client->id.'/edit')->with('success', 'Record created');
           
        }else{
            
            return redirect()->back()->with('error', 'Record not created');
        } 
    }
    
    /**
     *
     *
     * @param Client $client Model
     * 
     * @return view Modal Yes/No delete
     */
    public function getModalDelete(Client $client)
    {
        $model = 'client';
        $item  = $client;
        $confirm_route = $error = null;
        
        try {
            
            $confirm_route = route('admin.client.delete',$client->id);
            
            return view('admin.layouts.modal_confirmation', compact('item','error', 'model', 'confirm_route'));
        
        } catch (GroupNotFoundException $e) {

            return view('admin.layouts.modal_confirmation', compact('item', 'model', 'confirm_route'));
        
        }
    }
    
    /**
     * Delete client
     *
     * @param Client $client Model
     * 
     * @return Redirect to Clients list
     */
    public function destroy(Client $client){
        
        
        if(Client::find($client->id)->delete()){
            
            return redirect('admin/clients/')->with('success', 'Record deleted');
        }
    }
}

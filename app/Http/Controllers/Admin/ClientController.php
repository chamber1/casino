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
 * Description of DashboardController
 *
 * @author yuren
 */
class ClientController extends Controller{
    
    
    public function __construct()
    {
        $this->middleware('auth');
     
    }
    
    public function index() {

        
        return view('admin/client/index');   
    }
    
    public function delete() {
        
        
    }
    
    public function data() {
        
        $tables = Client::select(['id', 'name','phone']);
     
        return DataTables::of($tables)
            ->addColumn('action', function (Client $tables) {
                $html = '<a href="' . URL::to('admin/client/' . $tables->id . '/edit') . '" class="btn btn btn-primary btn-sm btn-sm-table"><i class="fa fa-edit"></i>Edit</a>&nbsp;&nbsp;&nbsp;';
                $html.= '<a href="'.URL::to('admin/client/' . $tables->id . '/confirm-delete').'" 
                                    class="btn btn btn-danger btn-sm delete-modal btn-sm-table"
                                    data-toggle="modal" data-target="#delete_confirm">
                                    <i class="fa fa-trash-o"></i>Delete
                              </a>';
                return $html;
            })
            ->removeColumn('id')
            ->make(true);
    }
    

    public function create()
    {
        return view('admin.client.create');
    }
    
    
    
    public function edit(Request $request,Client $client)
    {   
        $clientModel = Client::find($client->id);
        
       // dd($clientModel);
       
        return view('admin.client.edit',compact('clientModel'));
    }

    public function update(Request $request,Client $client)
    {
       
        $client->name = $request->input('name');
        //$client->user_id = Auth::user()->id;
        
        $client->phone = $request->input('phone');
        
        if ($client->update()) {
           return redirect()->back()->withSuccess('Record updated');;
        } 
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ClientRequest $request)
    {
        $client = new Client();


        $client->name = $request->input('name');
        //$post->user_id = Auth::user()->id;
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
     *.
     *
     * @param Test $test
     * @return Response
     */
    public function getModalDelete(Client $client)
    {
        $model = 'client';
        $item  = $client;
        
        //dd($client->id);
        $confirm_route = $error = null;
        
        
        try {
            $confirm_route = route('admin.client.delete',$client->id);
            return view('admin.layouts.modal_confirmation', compact('item','error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {

          
            return view('admin.layouts.modal_confirmation', compact('item', 'model', 'confirm_route'));
        }
    }
    
    public function destroy(Client $client){
        
        
        if(Client::find($client->id)->delete()){
            
            return redirect('admin/clients/')->with('success', 'Record deleted');
            
            
        }
    }
    

}

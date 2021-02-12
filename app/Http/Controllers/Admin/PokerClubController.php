<?php

namespace App\Http\Controllers\Admin;

use Request;
use App\Models\PokerClub;
use App\Services\ImageService;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PokerClubRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

/**
 * Handles ADMIN PANEL Poker Club
 *
 * @author Yurii Yurenko <yurenkoyura@gmail.com>
 */
class PokerClubController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->images_path = '/uploads/images/pokerclub/';
    }
    
    /**
     * Shows All Poker club data grid view .
     * 
     *
     * @return Events Data grid view
     */
    public function index() {
        return view('admin/pokerclub/index');   
    }
    
    /**
     * Get All Poker club data.
     * 
     *
     * @return DataTables object
     */
    public function data() {
        
        $tables = PokerClub::select(['id', 'name','icon','by_in','stack','levels']);
        
        return DataTables::of($tables)
            ->addColumn('action', function (PokerClub $tables) {
                $html = '<a href="' . URL::to('admin/pokerclub/' . $tables->id . '/edit') . '" class="btn btn btn-primary btn-sm btn-sm-table"><i class="fa fa-edit"></i>Edit</a>&nbsp;&nbsp;&nbsp;';
                $html.= '<a href="'.URL::to('admin/pokerclub/' . $tables->id . '/confirm-delete').'" 
                                    class="btn btn btn-danger btn-sm delete-modal btn-sm-table"
                                    data-toggle="modal" data-target="#delete_confirm">
                                    <i class="fa fa-trash-o"></i>Delete
                              </a>';
                return $html;
            })
            ->removeColumn('id')
            ->make(true);
    }
     
    /**
     * Create Poker club form.
     * 
     *
     * @return view
     */
    public function create()
    {
        return view('admin.pokerclub.create');
    }
    
    /**
     * Edit Poker club form.
     * 
     * @param PokerClubRequest $request
     * @param PokerClub $pokerclub Model
     *
     * @return view
     */
    public function edit(PokerClubRequest $request,PokerClub $pokerclub)
    {   
       return view('admin.pokerclub.edit',compact('pokerclub'));
    }
    
     /**
     * Update poker club.
     * 
     * @param PokerClubRequest $request
     * @param PokerClub $pokerclub Model
     *
     * @return Redirect on New client created
     */
    public function update(PokerClubRequest $request,PokerClub $pokerclub)
    {
        $pokerclub->name = $request->input('name');
        $pokerclub->by_in = $request->input('by_in');
        $pokerclub->stack = $request->input('stack');
        $pokerclub->levels = $request->input('levels');
        
        if ($request->hasFile('icon'))
        {
            if(file_exists(public_path($pokerclub->icon))) {
                unlink(public_path($pokerclub->icon));
            }
            $image          = $request->file('icon');
            $extension      = $image->extension()?: 'png';
            $filenameOrigin = uniqid();
            $filename       = $filenameOrigin.'.'.$extension;
            $image_resize   = Image::make($image->getRealPath());
            $dir_path = public_path($this->images_path);
            if (!is_dir($dir_path)) {
                mkdir($dir_path);
            }
            $image_resize->save(public_path($this->images_path .$filename));
            $pokerclub->icon = $this->images_path .$filename;
        }
        
        if ($pokerclub->update()) {
           return redirect()->back()->withSuccess('Запись обновлена');;
        } 
    }
    
    /**
     * Store a newly created Poker club new.
     * 
     * @param PokerClubRequest $request
     *
     * @return Redirect on newlу created poker club new
     */
    public function store(PokerClubRequest $request)
    {
        $club = new PokerClub();
        $club->name = $request->input('name');
        $club->by_in = $request->input('by_in');
        $club->stack = $request->input('stack');
        $club->levels = $request->input('levels');
        $club->save();
        
        if ($request->hasFile('icon'))
        {
           $image          = $request->file('icon');
            $extension      = $image->extension()?: 'png';
            $filenameOrigin = uniqid();
            $filename       = $filenameOrigin.'.'.$extension;
            $image_resize   = Image::make($image->getRealPath());
            $dir_path = public_path($this->images_path);
            if (!is_dir($dir_path)) {
                mkdir($dir_path);
            }
            $image_resize->save(public_path($this->images_path .$filename));
            $club->icon = $this->images_path .$filename;
        }
        
        $club->save();

        if ($club->id) {
            
            return redirect('admin/pokerclub/'.$club->id.'/edit')->with('success', 'Запись успешно добавлена');
           
        }else{
            
            return redirect()->back()->with('error', 'Запись не добавлена');
        } 

    }
    
    /**
     *
     *
     * @param PockerClub $pokerclub Model
     * 
     * @return view Modal Yes/No delete
     */
    public function getModalDelete(PokerClub $pokerclub)
    {
        $model = 'pokerclub';
        $item  = $pokerclub;
        $confirm_route = $error = null;
        
        try {
            
            $confirm_route = route('admin.pokerclub.delete',$pokerclub->id);
            
            return view('admin.layouts.modal_confirmation', compact('item','error', 'model', 'confirm_route'));
        
        } catch (GroupNotFoundException $e) {
            
            return view('admin.layouts.modal_confirmation', compact('item', 'model', 'confirm_route'));
        }
    }
    
    /**
     * Delete event and image for this event
     *
     * @param PockerClub $pokerclub
     * 
     * @return Redirect to PockerClub list
     */
    public function destroy(PokerClub $pokerclub){
        
        if(file_exists(public_path($pokerclub->icon))) {
            unlink(public_path($pokerclub->icon));
        }
        
        if($pokerclub->delete()){
            return redirect('admin/pokerclub/')->with('success', 'Запись успешно удалена');
        }
    }
}

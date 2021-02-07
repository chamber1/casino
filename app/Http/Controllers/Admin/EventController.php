<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Request;
use App\Services\ImageService;
use Yajra\DataTables\DataTables;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

/**
 * Handles ADMIN PANEL events
 *
 * @author Yurii Yurenko <yurenkoyura@gmail.com>
 */
class EventController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->server_URL = "http://".Request::server ("HTTP_HOST");
        $this->images_path = '/uploads/images/events/';
    }
    
    /**
     * Shows All Events Data grid view .
     * 
     *
     * @return Events Data grid view
     */
    public function index() {

        $server_URL = $this->server_URL;
        return view('admin/event/index', compact('server_URL'));   
    }
    
    /**
     * Get All Events data.
     * 
     *
     * @return DataTables object
     */
    public function data() {
        
        $tables = Event::select(['id', 'name','description','image_URL']);
     
        return DataTables::of($tables)
            ->addColumn('action', function (Event $tables) {
                $html = '<a href="' . URL::to('admin/event/' . $tables->id . '/edit') . '" class="btn btn btn-primary btn-sm btn-sm-table"><i class="fa fa-edit"></i>Edit</a>&nbsp;&nbsp;&nbsp;';
                $html.= '<a href="'.URL::to('admin/event/' . $tables->id . '/confirm-delete').'" 
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
     * Create event form.
     * 
     *
     * @return view
     */
    public function create()
    {
        return view('admin.event.create');
    }
    
    /**
     * Edit event form.
     * 
     * @param EventRequest $request
     * @param Event $event Model
     *
     * @return view
     */
    public function edit(EventRequest $request,Event $event)
    {   
       return view('admin.event.edit',compact('event'));
    }
    
     /**
     * Update event.
     * 
     * @param EventRequest $request
     * @param Event $event Model
     *
     * @return Redirect on New client created
     */
    public function update(EventRequest $request,Event $event)
    {
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        
        if ($request->hasFile('image_URL'))
        {
            if(file_exists(public_path($event->image_URL))) {
                unlink(public_path($event->image_URL));
            }
            $image          = $request->file('image_URL');
            $extension      = $image->extension()?: 'png';
            $filenameOrigin = uniqid();
            $filename       = $filenameOrigin.'.'.$extension;
            $image_resize   = Image::make($image->getRealPath());
            $dir_path = public_path($this->images_path);
            if (!is_dir($dir_path)) {
                mkdir($dir_path);
            }
            $image_resize->save(public_path($this->images_path .$filename));
            $event->image_URL = $this->images_path .$filename;
        }
        
        if ($event->update()) {
           return redirect()->back()->withSuccess('Запись обновлена');;
        } 
    }
    
    /**
     * Store a newly created event.
     * 
     * @param EventRequest $request
     *
     * @return Redirect on newlу created event
     */
    public function store(EventRequest $request)
    {
        $event = new Event();
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->image_URL = null; 
        $event->save();
        
        if ($request->hasFile('image_URL'))
        {
            $server_URL = "http://".Request::server ("HTTP_HOST");
            $image          = $request->file('image_URL');
            $extension      = $image->extension()?: 'png';
            $filenameOrigin = uniqid();
            $filename       = $filenameOrigin.'.'.$extension;
            $image_resize   = Image::make($image->getRealPath());
            $dir_path = public_path($this->images_path);
            if (!is_dir($dir_path)) {
                mkdir($dir_path);
            }
            $image_resize->save(public_path($this->images_path .$filename));
            $event->image_URL = $this->images_path .$filename;
        }
        
        $event->save();

        if ($event->id) {
            
            return redirect('admin/event/'.$event->id.'/edit')->with('success', 'Запись успешно добавлена');
           
        }else{
            
            return redirect()->back()->with('error', 'Record not created');
        } 

    }
    
    /**
     *
     *
     * @param Event $event Model
     * 
     * @return view Modal Yes/No delete
     */
    public function getModalDelete(Event $event)
    {
        $model = 'event';
        $item  = $event;
        $confirm_route = $error = null;
        
        try {
            
            $confirm_route = route('admin.event.delete',$event->id);
            
            return view('admin.layouts.modal_confirmation', compact('item','error', 'model', 'confirm_route'));
        
        } catch (GroupNotFoundException $e) {
            
            return view('admin.layouts.modal_confirmation', compact('item', 'model', 'confirm_route'));
        }
    }
    
    /**
     * Delete event and image for this event
     *
     * @param Event $event
     * 
     * @return Redirect to Events list
     */
    public function destroy(Event $event){
        
        if(file_exists(public_path($event->image_URL))) {
            unlink(public_path($event->image_URL));
        }
        
        if($event->delete()){
            return redirect('admin/events/')->with('success', 'Запись успешно удалена');
        }
    }
}

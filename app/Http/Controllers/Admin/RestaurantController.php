<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restaurant;
use App\Models\RestaurantImage;
use Request;
use App\Services\ImageService;
use Yajra\DataTables\DataTables;
use App\Http\Requests\RestaurantRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

/**
 * Handles ADMIN PANEL Restaurant
 *
 * @author Yurii Yurenko <yurenkoyura@gmail.com>
 */
class RestaurantController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->images_path = '/uploads/images/restaurant/';
    }
    
    /**
     * Shows All Events Data grid view .
     * 
     *
     * @return Events Data grid view
     */
    public function index() {

        return view('admin/restaurant/index');   
    }
    
    /**
     * Get All Events data.
     * 
     *
     * @return DataTables object
     */
    public function data() {
        
        $tables = Restaurant::select(['id', 'name','main_image_URL','menu_image_URL']);
     
        return DataTables::of($tables)
            ->addColumn('action', function (Restaurant $tables) {
                $html = '<a href="' . URL::to('admin/restaurant/' . $tables->id . '/edit') . '" class="btn btn btn-primary btn-sm btn-sm-table"><i class="fa fa-edit"></i>Edit</a>&nbsp;&nbsp;&nbsp;';
                $html.= '<a href="'.URL::to('admin/restaurant/' . $tables->id . '/confirm-delete').'" 
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
        return view('admin.restaurant.create');
    }
    
    /**
     * Edit event form.
     * 
     * @param EventRequest $request
     * @param Event $event Model
     *
     * @return view
     */
    public function edit(RestaurantRequest $request,Restaurant $restaurant)
    { 
       return view('admin.restaurant.edit',compact('restaurant'));
    }
    
     /**
     * Update event.
     * 
     * @param EventRequest $request
     * @param Event $event Model
     *
     * @return Redirect on New client created
     */
    public function update(RestaurantRequest $request,Restaurant $restaurant)
    {
        $restaurant->name = $request->input('name');
       
        if ($request->hasFile('main_image_URL'))
        {
            if(file_exists(public_path($restaurant->main_image_URL))) {
                unlink(public_path($restaurant->main_image_URL));
            }
            
            $image = $request->file('main_image_URL');
            $restaurant->main_image_URL = $this->copyImage($image);
        }
        
        if ($request->hasFile('images'))
        {
            if(isset($restaurant->images) && !empty($restaurant->images)){
                foreach ($restaurant->images as $menu_image){
                   if(file_exists(public_path($menu_image->menu_image_URL))) {
                       unlink(public_path($menu_image->menu_image_URL));
                   }
                }
            }
            
            RestaurantImage::Where('restaurant_id','=',$restaurant->id)->delete();
            $images = $request->file('images');
            foreach ($images as $file) {
                $menu_image = new RestaurantImage();
                $menu_image->restaurant_id = $restaurant->id;
                $menu_image->menu_image_URL = $this->copyImage($file);
                $menu_image->save();
            }
        }
        
        if ($restaurant->update()) {
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
    public function store(RestaurantRequest $request)
    {
        $restaurant = new Restaurant();
        $restaurant->name = $request->input('name');
        $restaurant->main_image_URL = null;
        $restaurant->save();
        $restaurant_id = $restaurant->id;
        
        if ($request->hasFile('main_image_URL'))
        {
            $image = $request->file('main_image_URL');
            $restaurant->main_image_URL = $this->copyImage($image);
            $restaurant->save();
        }
        
        if ($request->hasFile('images'))
        {
            $images = $request->file('images');
            foreach ($images as $file) {
                $menu_image = new RestaurantImage();
                $menu_image->restaurant_id = $restaurant_id;
                $menu_image->menu_image_URL = $this->copyImage($file);
                $menu_image->save();
            }
        }
        
        if ($restaurant->id) {
            return redirect('admin/restaurant/'.$restaurant->id.'/edit')->with('success', 'Запись успешно добавлена');
        }else{
            return redirect()->back()->with('error', 'Запись не добавлена');
        } 

    }
    
    /**
     *Copy image to upload folder
     *
     * @param string $request_filename
     * 
     * @return string filename
     */
    public function copyImage($image){
        
        $extension      = $image->extension()?: 'png';
        $filenameOrigin = uniqid();
        $filename       = $filenameOrigin.'.'.$extension;
        $image_resize   = Image::make($image->getRealPath());
        $dir_path = public_path($this->images_path);
        if (!is_dir($dir_path)) {
            mkdir($dir_path);
        }
        $image_resize->save(public_path($this->images_path .$filename));
        
        return $this->images_path .$filename;
    }
    
    /**
     *
     *
     * @param Restaurant $restaurant Model
     * 
     * @return view Modal Yes/No delete
     */
    public function getModalDelete(Restaurant $restaurant)
    {
        $model = 'restaurant';
        $item  = $restaurant;
        $confirm_route = $error = null;
        
        try {
            
            $confirm_route = route('admin.restaurant.delete',$restaurant->id);
            
            return view('admin.layouts.modal_confirmation', compact('item','error', 'model', 'confirm_route'));
        
        } catch (GroupNotFoundException $e) {
            
            return view('admin.layouts.modal_confirmation', compact('item', 'model', 'confirm_route'));
        }
    }
    
    /**
     * Delete restaurant and menu images for this restaurant
     *
     * @param Restaurant $restaurant 
     * 
     * @return Redirect to Restaurant  list
     */
    public function destroy(Restaurant $restaurant){
        
        if(file_exists(public_path($restaurant->main_image_URL))) {
            unlink(public_path($restaurant->main_image_URL));
        }
        
        if(isset($restaurant->images) && !empty($restaurant->images)){
            foreach ($restaurant->images as $menu_image){
               if(file_exists(public_path($menu_image->menu_image_URL))) {
                   unlink(public_path($menu_image->menu_image_URL));
               }
            }
        }
        RestaurantImage::Where('restaurant_id','=',$restaurant->id)->delete();
        if($restaurant->delete()){
            return redirect('admin/restaurant/')->with('success', 'Запись успешно удалена');
        }
    }
}

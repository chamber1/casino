<?php
namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use \Illuminate\Http\Request;

/**
 * Description of DashboardController
 *
 * @author yuren
 */
class PostController extends Controller{
    
    
    public function __construct()
    {
        $this->middleware('auth');
     
    }
    
    public function index() {

        
        return view('admin/post/index');   
    }
    
    public function delete() {
        
        
    }
    
    public function data() {
        
        $tables = Post::select(['id', 'title','body']);
     
        return DataTables::of($tables)
            ->addColumn('action', function (Post $tables) {
                $html = '<a href="' . URL::to('admin/post/' . $tables->id . '/edit') . '" class="btn btn btn-primary btn-sm btn-sm-table"><i class="fa fa-edit"></i>Edit</a>&nbsp;&nbsp;&nbsp;';
                $html.= '<a href="'.URL::to('admin/post/' . $tables->id . '/confirm-delete').'" 
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
        return view('admin.post.create');
    }
    
    
    
    public function edit(Request $request,Post $post)
    {   
        $postModel = Post::find($post->id);
       
        return view('admin.post.edit',compact('postModel'));
    }

    public function update(PostRequest $request,Post $post)
    {
       
        $post->title = $request->input('title');
        $post->user_id = Auth::user()->id;
        $post->body = $request->input('body');
        
        if ($post->update()) {
           return redirect()->back()->withSuccess('Record updated');;
        } 
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post();


        $post->title = $request->input('title');
        $post->user_id = Auth::user()->id;
        $post->body = $request->input('body');
        $post->save();


        if ($post->id) {
            
            return redirect('admin/post/'.$post->id.'/edit')->with('success', 'Record created');
           
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
    public function getModalDelete(Post $post)
    {
        $model = 'post';
        $item  = $post;
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.post.delete', ['id' => $post->id]);
            return view('admin.layouts.modal_confirmation', compact('item','error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {

            $error = trans('region/message.error.delete', compact('id'));
            return view('admin.layouts.modal_confirmation', compact('error','item_mame', 'model', 'confirm_route'));
        }
    }
    
    public function destroy(Post $post){
        
        
        if(Post::find($post->id)->delete()){
            
            return redirect('admin/post/')->with('success', 'Record deleted');
            
            
        }
    }
    

}

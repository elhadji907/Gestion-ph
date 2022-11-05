<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{

    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:super-admin']);
        $this->middleware('permission:view-category|create-category|edit-category|destroy-category', ['only' => ['index']]);
         $this->middleware('permission:create-category', ['only' => ['create','store']]);
         $this->middleware('permission:edit-category', ['only' => ['edit','update']]);
         $this->middleware('permission:destroy-category', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'categories';
        $categories = Category::get();
        if($request->ajax()){
            /* $categories = Category::get(); */
            return DataTables::of($categories)
                    ->addIndexColumn()
                    ->addColumn('created_at',function($category){
                        return date_format(date_create($category->created_at),"d/m/yy");
                    })
                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" data-name="'.$row->name.'" href="javascript:void(0)" class="editbtn"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('categories.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if(!auth()->user()->hasPermissionTo('edit-category')){
                            $editbtn = '';
                        }
                        if(!auth()->user()->hasPermissionTo('destroy-category')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.products.categories',compact(
            'title', 'categories'
        ));
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:100',
        ]);
        Category::create($request->all());
        $notification=array("La catégorie a été ajoutée");
        return back()->with($notification);
    }

    

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,['name'=>'required|max:100']);
        $category = Category::find($request->id);
        $category->update([
            'name'=>$request->name,
        ]);
        $notification = notify("La catégorie a été mise à jour");
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Category::findOrFail($request->id)->delete();
    }
}

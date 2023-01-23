<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use Auth;

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
        $categories = Category::latest();
        if ($request->ajax()) {
            /* $categories = Category::get(); */
            return DataTables::of($categories)
                    ->addIndexColumn()
                    ->addColumn('created_at', function ($category) {
                        return date_format(date_create($category->created_at), "d/m/Y");
                    })
                    ->addColumn('action', function ($row) {
                        $editbtn = '<a data-id="'.$row->id.'" data-name="'.$row->categorie.'" href="javascript:void(0)" class="editbtn"><button class="btn btn-sm bg-primary-light"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('categories.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-sm bg-danger-light"><i class="fas fa-trash"></i></button></a>';
                        if (!auth()->user()->hasPermissionTo('edit-category')) {
                            $editbtn = '';
                        }
                        if (!auth()->user()->hasPermissionTo('destroy-category')) {
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.products.categories', compact(
            'title',
            'categories'
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
        $this->validate($request, [
            /* 'name'=>'required|max:100|unique:categories,name,NULL,id,deleted_at,NULL', */
            'categories.*.categorie' => 'required'
        ]);

        $user_connect           =   Auth::user();

        $created_by  = strtolower($user_connect->name);
        $updated_by  = strtolower($user_connect->name);

        /* Category::create($request->all()); */

        foreach ($request->categories as $key => $value) {
            Category::create($value);
            /*  Category::create(
                 [
                 'name'=>$value->categorie,
                 'created_by'=>$created_by,
                 'updated_by'=>$updated_by,
             ]
             ); */
        }

        /*       Category::create(
                  [
                  'name'=>$request->name,
                  'created_by'=>$created_by,
                  'updated_by'=>$updated_by,
              ]
              ); */

        $notification=notify("La catégorie a été ajoutée");
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
        $this->validate($request, ['categorie'=>'required|max:100|unique:categories,categorie,'.$request->id.',id,deleted_at,NULL']);
        $category = Category::find($request->id);

        $user_connect           =   Auth::user();

        $updated_by  = strtolower($user_connect->name);

        $category->update([
            'categorie'=>$request->categorie,
            'updated_by'=>$updated_by,
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
    public function destroy($id)
    {
        $user_connect           =   Auth::user();

        $deleted_by  = strtolower($user_connect->name);

        $category = Category::find($id);

        $category->deleted_by = $deleted_by;
        $category->save();

        return Category::find($id)->delete();
    }
}

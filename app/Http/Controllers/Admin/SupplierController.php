<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Fournisseurs';
        if($request->ajax()){
            $suppliers = Supplier::latest();
            return DataTables::of($suppliers)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("suppliers.edit", $row->id).'" class="editbtn"><button class="btn btn-sm bg-primary-light"><i class="fas fa-edit"></i></button></a>';
                    $showbtn = '<a href="'.route("suppliers.supplier", $row->id).'" class="showbtn" target="_blank" title="Voir"><button class="btn btn-sm bg-info-light"><i class="fa fa-eye" aria-hidden="true"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('suppliers.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-sm bg-danger-light"><i class="fas fa-trash"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-supplier')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-supplier')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$showbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('admin.suppliers.index',compact(
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Créer un fournisseur';
        return view('admin.suppliers.create',compact(
            'title'
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
            'name'=>'required|min:3|max:255|unique:suppliers,name,NULL,NULL,deleted_at,NULL',
            'product'=>'nullable',
            'email'=>'nullable|email|string',
            'phone'=>'required|min:9|max:20',
            'company'=>'nullable|max:200',
            'address'=>'required|max:200',
            'comment' =>'nullable|max:255',
        ]);
        Supplier::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'company'=>$request->company,
            'address'=>$request->address,
            'product'=>$request->product,
            'comment'=>$request->comment,
        ]);
        $notification = notify("Le fournisseur a été ajouté");
        return redirect()->route('suppliers.index')->with($notification);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $title = 'Modifier le fournisseur';
        return view('admin.suppliers.edit',compact(
            'title','supplier'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->validate($request,[
            'name'=>'required|min:3|max:255|unique:suppliers,name,'.$supplier->id.',id,deleted_at,NULL',
            'product'=>'nullable',
            'email'=>'nullable|email|string',
            'phone'=>'required|min:9|max:20',
            'company'=>'nullable|max:200',
            'address'=>'required|max:200',
            'comment' =>'nullable|max:255',
        ]);
        $supplier->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'company'=>$request->company,
            'address'=>$request->address,
            'product'=>$request->product,
            'comment'=>$request->comment,
        ]);
        $notification = notify("Le fournisseur a été ajouté");
        return redirect()->route('suppliers.index')->with($notification);
    }


    public function supplier($id) {
        $suppliers = Supplier::find($id);
        $title = $suppliers->name;
        return view('admin.suppliers.supplier', compact('suppliers', 'title'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Supplier::findOrFail($request->id)->delete();
    }
}

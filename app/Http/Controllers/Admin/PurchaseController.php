<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use QCod\AppSettings\Setting\AppSettings;
use App\Notifications\StockAlertNotification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* $title = 'Stock';
        if ($request->ajax()) {
            $purchases = Purchase::latest();
            return DataTables::of($purchases)
                ->addColumn('product', function ($purchase) {
                    $image = '';
                    if (!empty($purchase->image)) {
                        $image = '<span class="avatar avatar-sm mr-2">
						<img class="avatar-img" src="'.asset("storage/purchases/".$purchase->image).'" alt="product">
					    </span>';
                    }
                    return $purchase->product.' ' . $image;
                })
                ->addColumn('category', function ($purchase) {
                    if (!empty($purchase->category)) {
                        return $purchase->category->categorie ?? '';
                    }
                })
                ->addColumn('cost_price', function ($purchase) {
                    return settings('app_currency', ''). ' '. $purchase->cost_price;
                })
                ->addColumn('supplier', function ($purchase) {
                    return $purchase->supplier->name ?? '';
                })
                ->addColumn('quantity', function ($purchase) {
                    return $purchase->quantity ?? '';
                })
                ->addColumn('expiry_date', function ($purchase) {
                    return date_format(date_create($purchase->expiry_date), 'd/m/Y');
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("purchases.edit", $row->id).'" class="editbtn"><button class="btn btn-sm bg-primary-light"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('purchases.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-sm bg-danger-light"><i class="fas fa-trash"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-purchase')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-purchase')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['product','action'])
                ->make(true);
        } */

        
        $title = 'Stock';
        $products = Purchase::get();

        foreach ($products as $key => $product) {
            //dd($product);
            if ($request->ajax()) {
                //$products = Product::latest();
                return DataTables::of($products)
                    ->addColumn('product', function ($product) {
                        $image = '';
                        if (!empty($product)) {
                            $image = null;
                            if (!empty($product->image)) {
                                $image = '<span class="avatar avatar-sm mr-2">
                            <img class="avatar-img" src="'.asset("storage/purchases/".$product->image).'" alt="image">
                            </span>';
                            }
                            return $product->product. ' ' . $image;
                        }
                    })

                    ->addColumn('category', function ($product) {
                        $category = null;
                        if (!empty($product->category)) {
                            $category = $product->category->categorie;
                        }
                        return $category;
                    })
                    ->addColumn('supplier', function ($purchase) {
                        return $purchase->supplier->name ?? '';
                    })
                    ->addColumn('price', function ($product) {
                        /* return settings('app_currency','CFA').' '. $product->price; */
                        return settings('app_currency', '').' '. $product->cost_price;
                    })
                    ->addColumn('quantity', function ($product) {
                        if (!empty($product)) {
                            return $product->quantity;
                        }
                    })
                    ->addColumn('discount', function ($product) {
                        if (!empty($product)) {
                            return $product->discount;
                        }
                    })
                    ->addColumn('expiry_date', function ($product) {
                        if (!empty($product)) {
                            return date_format(date_create($product->expiry_date), 'd/m/Y');
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $editbtn = '<a href="'.route("purchases.edit", $row->id).'" class="editbtn"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('purchases.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if (!auth()->user()->hasPermissionTo('edit-product')) {
                            $editbtn = '';
                        }
                        if (!auth()->user()->hasPermissionTo('destroy-purchase')) {
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['product','action'])
                    ->make(true);
            }
        }

        return view('admin.purchases.index', compact(
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
        $title = 'Ajouter un stock';
        $categories = Category::get();
        $suppliers = Supplier::get();
        return view('admin.purchases.create', compact(
            'title',
            'categories',
            'suppliers'
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
            'product'=>'required|max:200',
            'category'=>'required',
            'cost_price'=>'required|min:1',
            'quantity'=>'required|min:1',
            'expiry_date'=>'required',
            'supplier'=>'required',
            'tva'=>'nullable|numeric',
            'image'=>'file|image|mimes:jpg,jpeg,png,gif',
        ]);
        /* dd($request->tva); */
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage/purchases'), $imageName);
        }

        $purchase = Purchase::create([
            'product'=>$request->product,
            'category_id'=>$request->category,
            'supplier_id'=>$request->supplier,
            'cost_price'=>$request->cost_price,
            'quantity'=>$request->quantity,
            'expiry_date'=>$request->expiry_date,
            'image'=>$imageName,
            'vendu'=>"Non",
            'item'=>$request->tva,
        ]);

        $purchase->notify(new StockAlertNotification($purchase, auth()->user()));

        $notifications = notify("L’achat a été ajouté");
        /* return redirect()->route('purchases.index')->with($notifications); */
        return back()->with($notifications);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $title = 'Modifier stock';
        $categories = Category::get();
        $suppliers = Supplier::get();
        return view('admin.purchases.edit', compact(
            'title',
            'purchase',
            'categories',
            'suppliers'
        ));
    }

    public function showFromNotification(Purchase $purchase, DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $this->validate($request, [
            'product'=>'required|max:200',
            'category'=>'required',
            'cost_price'=>'required|min:1',
            'quantity'=>'required|min:1',
            'expiry_date'=>'required',
            'supplier'=>'required',
            'tva'=>'nullable|numeric',
            'image'=>'file|image|mimes:jpg,jpeg,png,gif',
        ]);
        
        $imageName = $purchase->image;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage/purchases'), $imageName);
        }
        $purchase->update([
            'product'=>$request->product,
            'category_id'=>$request->category,
            'supplier_id'=>$request->supplier,
            'cost_price'=>$request->cost_price,
            'quantity'=>$request->quantity,
            'item'=>$request->tva,
            'expiry_date'=>$request->expiry_date,
            'image'=>$imageName,
        ]);
        $notifications = notify("L’achat a été mis à jour");
        return redirect()->route('purchases.index')->with($notifications);
    }

    public function reports()
    {
        $title ='Rapports achat';
        return view('admin.purchases.reports', compact('title'));
    }

    public function generateReport(Request $request)
    {
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $now =  Carbon::now()->format('H:i:s');
        //dd($now);
        $from_date = date_format(date_create($request->from_date), 'd/m/Y');
        $to_date = date_format(date_create($request->to_date), 'd/m/Y');
        if ($from_date == $to_date) {
            $title = 'Achats du '.$from_date.' à '.$now;
        }else {
            $from_date = date_format(date_create($request->from_date), 'd/m/Y');
            $title = 'Achats du '.$from_date.' au '.$to_date.' à '.$now;
        }
        $purchases = Purchase::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->get();
        return view('admin.purchases.reports', compact(
            'purchases','from_date','to_date',
            'title'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Purchase::findOrFail($request->id)->delete();
    }
}

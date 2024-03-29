<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
/* use Illuminate\Support\Carbon; */
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use QCod\AppSettings\Setting\AppSettings;
use Carbon\Carbon;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       /*  $title = 'Produits';
        if ($request->ajax()) {
            $products = Product::latest();
            return DataTables::of($products)
                ->addColumn('product', function ($product) {
                    $image = '';
                    if (!empty($product->purchase)) {
                        $image = null;
                        if (!empty($product->purchase->image)) {
                            $image = '<span class="avatar avatar-sm mr-2">
                            <img class="avatar-img" src="'.asset("storage/purchases/".$product->purchase->image).'" alt="image">
                            </span>';
                        }
                        return $product->purchase->product. ' ' . $image;
                    }
                })

                ->addColumn('category', function ($product) {
                    $category = null;
                    if (!empty($product->purchase->category)) {
                        $category = $product->purchase->category->categorie;
                    }
                    return $category;
                })
                ->addColumn('price', function ($product) {
                    return settings('app_currency', '').' '. $product->price;
                })
                ->addColumn('quantity', function ($product) {
                    if (!empty($product->purchase)) {
                        return $product->purchase->quantity;
                    }
                })
                ->addColumn('expiry_date', function ($product) {
                    if (!empty($product->purchase)) {
                        return date_format(date_create($product->purchase->expiry_date), 'd/m/Y');
                    }
                })
                ->addColumn('vendu', function ($product) {
                    if (!empty($product->purchase)) {
                        return $product->purchase->vendu;
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("products.edit", $row->id).'" class="editbtn"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('products.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
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
        return view('admin.products.index', compact(
            'title'
        )); */

        

        $title = 'Produits';
        /* $products = Product::whereDate('expiry_date', '<=', Carbon::now())->where('quantity', '>', '0')->get(); */

        /* dd($products); */

        /* foreach ($products as $key => $product) { */
            //dd($product);
            if ($request->ajax()) {
                //$products = Product::latest();
                $products = Product::all();
                return DataTables::of($products)
                ->addColumn('product', function ($product) {
                    $image = '';
                    if (!empty($product->purchase)) {
                        $image = null;
                        if (!empty($product->purchase->image)) {
                            $image = '<span class="avatar avatar-sm mr-2">
                            <img class="avatar-img" src="'.asset("storage/purchases/".$product->purchase->image).'" alt="image">
                            </span>';
                        }
                        return $product->purchase->product. ' ' . $image;
                    }
                })

                    ->addColumn('category', function ($product) {
                        $category = null;
                        if (!empty($product->purchase->category)) {
                            $category = $product->purchase->category->categorie;
                        }
                        return $category;
                    })

                    ->addColumn('price', function ($product) {
                        /* return settings('app_currency','CFA').' '. $product->price; */
                        return settings('app_currency', '').' '. $product->price ?? '';
                    })
                    ->addColumn('quantity', function ($product) {
                        if (!empty($product)) {
                            return $product->purchase->quantity;
                        }
                    })
                    ->addColumn('discount', function ($product) {
                        if (!empty($product)) {
                            return $product->discount;
                        }
                    })
                    ->addColumn('expiry_date', function ($product) {
                        if (!empty($product)) {
                            return date_format(date_create($product->purchase->expiry_date), 'd/m/Y');
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $editbtn = '<a href="'.route("products.edit", $row->id).'" class="editbtn"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('products.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
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
      /*   } */
        return view('admin.products.index', compact(
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
        $title = 'Ajouter un produit';
        $purchases = Purchase::get();
        return view('admin.products.create', compact(
            'title',
            'purchases'
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
            'producte'=>'required|max:200',
            'price'=>'required|min:1',
            'discount'=>'nullable',
            'description'=>'nullable|max:255',
        ]);
        $price = $request->price;
        if ($request->discount > 0) {
            /* $price = $request->discount * $request->price; */
            $price = $request->price - ($request->price * ($request->discount/100));
        }
        
        //pour le menu select
        /* $purchase = Purchase::findOrFail($request->product); */
        //pour le menu autocomplete
        
        $purchase = Purchase::findOrFail($request->id_product);

        /* dd($purchase->cost_price); */

        if ($purchase->cost_price >= $request->price) {           
            $this->validate($request, [
                'price'=>'min:'.$purchase->cost_price
            ],
            [
                'price.min' => 'Attention ! le prix de vente doit être supérieur au prix d\'achat'
            ]
        );
        } else {
        
            $purchase->update([
                'vendu'=>"Oui",
            ]);
    
            Product::create([
                'purchase_id'=>$request->id_product,
                'price'=>$price,
                'discount'=>$request->discount,
                'description'=>$request->description,
            ]);
    
    
            $notification = notify("Produit mis en vente");
        }
        return back()->with($notification);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $title = 'Modifier le produit';
        $purchases = Purchase::get();
        return view('admin.products.edit', compact(
            'title',
            'product',
            'purchases'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'product'=>'required|max:200',
            'price'=>'required',
            'discount'=>'nullable',
            'description'=>'nullable|max:255',
        ]);
        
        $price = $request->price;
        if ($request->discount > 0) {
            /* $price = $request->discount * $request->price; */            
            $price = $request->price - ($request->price * ($request->discount/100));
            $product->update([
                'discount'=>$request->discount,
            ]);
        } else {
            $product->update([
                'discount'=>$request->discounte,
            ]);
        }

        $product->update([
             'purchase_id'=>$request->product,
             'price'=>$price,
             'description'=>$request->description,
         ]);
        $notification = notify('Le produit a été mis à jour');
        return redirect()->route('products.index')->with($notification);
    }

     /**
     * Display a listing of expired resources.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function expired(Request $request)
    {
        /* $title = "Produits expirés";
        if ($request->ajax()) {
            $products = Purchase::whereDate('expiry_date', '=', Carbon::now())->get();
            return DataTables::of($products)
                ->addColumn('product', function ($product) {
                    $image = '';
                    if (!empty($product->purchase)) {
                        $image = null;
                        if (!empty($product->purchase->image)) {
                            $image = '<span class="avatar avatar-sm mr-2">
                            <img class="avatar-img" src="'.asset("storage/purchases/".$product->purchase->image).'" alt="image">
                            </span>';
                        }
                        return $product->purchase->product. ' ' . $image;
                    }
                })

                ->addColumn('category', function ($product) {
                    $category = null;
                    if (!empty($product->purchase->category)) {
                        $category = $product->purchase->category->name;
                    }
                    return $category;
                })
                ->addColumn('price', function ($product) {
                    return settings('app_currency', '').' '. $product->price;
                })
                ->addColumn('quantity', function ($product) {
                    if (!empty($product->purchase)) {
                        return $product->purchase->quantity;
                    }
                })
                ->addColumn('discount', function ($product) {
                    if (!empty($product->purchase)) {
                        return $product->purchase->discount;
                    }
                })
                ->addColumn('expiry_date', function ($product) {
                    if (!empty($product->purchase)) {
                        return date_format(date_create($product->purchase->expiry_date), 'd/m/Y');
                    }
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("products.edit", $row->id).'" class="editbtn"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('products.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
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

        return view('admin.products.expired', compact(
            'title',
        )); */


        $title = 'Produits expirés';
        $products = Purchase::whereDate('expiry_date', '<=', Carbon::now())->where('quantity', '>', '0')->get();

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
                        $editbtn = '<a href="'.route("products.edit", $row->id).'" class="editbtn"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('products.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
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
        return view('admin.products.expired', compact(
            'title'
        ));
    }

    /**
     * Display a listing of out of stock resources.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function outstock(Request $request)
    {
        $title = "Produits en surstock";
        $products = Purchase::where('quantity', '<=', 0)->get();
        foreach ($products as $key => $product) {
            //dd($product);
            if ($request->ajax()) {
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
                            $editbtn = '<a href="'.route("products.edit", $row->id).'" class="editbtn"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                            $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('products.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
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
        //$product = Purchase::where('quantity', '<=', 10)->first();
        return view('admin.products.outstock', compact(
            'title',
        ));
    }

    public function getStates($id) {
        $states = DB::table("purchases")->where("vendu",'Non')->pluck("product","id");

        return json_encode($states);

    }

    function autocomplete(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      
      $mytime = Carbon::now();
      $mytime = $mytime->toDateTimeString();
      
      $data = DB::table('purchases')
        ->where('product', 'LIKE', "%{$query}%")
        ->where('expiry_date', '>=', "{$mytime}")
        ->where('quantity', '>=', "1")
        ->where('vendu', "Non")
        ->get();
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
        
       $output .= '
       <li data-id="'.$row->id.'" data-price="'.$row->cost_price.'" data-quantity="'.$row->quantity.'" data-tva="'.$row->item.'"><a href="#">'.$row->product.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        return Product::findOrFail($request->id)->delete();

       /*  $title = 'Produits';
        $product = Product::findOrFail($request->id);
        $purchase = $product->purchase;

        foreach ($product->sales as $sale) {
            if (isset($sale)) {
                $notification = notify("Le produit ne peut pas être supprimé");
                return view('admin.products.index', compact(
                    'title'
                ))->with($notification);
            } else {               
              return Product::findOrFail($request->id)->delete();
            }
         } */
        /*  foreach ($product->sales as $key => $sale) {
            $notification = notify("Le produit ne peut pas être supprimé");
            return view('admin.products.index', compact(
                'title'
            ));
         } */
    }
}

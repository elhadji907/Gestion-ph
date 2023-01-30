<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\Task;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Events\PurchaseOutStock;
use Yajra\DataTables\DataTables;
/* use Illuminate\Support\Facades\DB; */
use App\Http\Controllers\Controller;
use App\Notifications\SaleAlertNotification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;
use Auth;
use Dompdf\Dompdf;
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* $title = 'ventes';
        if ($request->ajax()) {
            $sales = Sale::latest();
            return DataTables::of($sales)
                    ->addIndexColumn()
                    ->addColumn('product', function ($sale) {
                        $image = '';
                        if (!empty($sale->product)) {
                            $image = null;
                            if (!empty($sale->product->purchase->image)) {
                                $image = '<span class="avatar avatar-sm mr-2">
                                <img class="avatar-img" src="'.asset("storage/purchases/".$sale->product->purchase->image).'" alt="image">
                                </span>';
                            }
                            return $sale->product->purchase->product. ' ' . $image;
                        }
                    })
                    ->addColumn('total_price', function ($sale) {
                        return settings('app_currency', '').' '. number_format(($sale->total_price ?? ''), 2, '.', ' ');
                    })
                    ->addColumn('price', function ($sale) {
                        return settings('app_currency', '').' '. number_format(($sale->product->price ?? ''), 2, '.', ' ');
                    })
                    ->addColumn('date', function ($row) {
                        return date_format(date_create($row->created_at), 'd/m/Y');
                    })
                    ->addColumn('action', function ($row) {
                        $editbtn = '<a href="'.route("sales.edit", $row->id).'" class="editbtn" title="Modifier"><button class="btn btn-sm bg-primary-light"><i class="fas fa-edit"></i></button></a>';
                        $showbtn = '<a href="'.route("sales.facture", $row->id).'" class="showbtn" target="_blank" title="Imprimer facture"><button class="btn btn-sm bg-info-light"><i class="fa fa-print" aria-hidden="true"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('sales.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"  title="Supprimer"><button class="btn btn-sm bg-danger-light"><i class="fas fa-trash"></i></button></a>';
                        if (!auth()->user()->hasPermissionTo('edit-sale')) {
                            $editbtn = '';
                        }
                        if (!auth()->user()->hasPermissionTo('destroy-sale')) {
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$showbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['product','action'])
                    ->make(true);
        } */

        $title = 'Ventes';
        $sales = Sale::get();
        foreach ($sales as $key => $sale) {
            if ($request->ajax()) {
                return DataTables::of($sales)
                ->addIndexColumn()
                ->addColumn('product', function ($sale) {
                    $image = '';
                    if (!empty($sale->product)) {
                        $image = null;
                        if (!empty($sale->product->purchase->image)) {
                            $image = '<span class="avatar avatar-sm mr-2">
                            <img class="avatar-img" src="'.asset("storage/purchases/".$sale->product->purchase->image).'" alt="image">
                            </span>';
                        }
                        return $sale->product->purchase->product. ' ' . $image;
                    }
                })
                
                ->addColumn('total_price', function ($sale) {
                    return settings('app_currency', '').' '. number_format(($sale->total_price ?? ''), 2, '.', ' ');
                })
                ->addColumn('price', function ($sale) {
                    return settings('app_currency', '').' '. number_format(($sale->product->price ?? ''), 2, '.', ' ');
                })
                ->addColumn('date', function ($row) {
                    return date_format(date_create($row->created_at), 'd/m/Y');
                })
                ->addColumn('action', function ($row) {
                    $editbtn = '<a href="'.route("sales.edit", $row->id).'" class="editbtn" title="Modifier"><button class="btn btn-sm bg-primary-light"><i class="fas fa-edit"></i></button></a>';
                    $showbtn = '<a href="'.route("sales.facture", $row->id).'" class="showbtn" target="_blank" title="Imprimer facture"><button class="btn btn-sm bg-info-light"><i class="fa fa-print" aria-hidden="true"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('sales.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"  title="Supprimer"><button class="btn btn-sm bg-danger-light"><i class="fas fa-trash"></i></button></a>';
                    if (!auth()->user()->hasPermissionTo('edit-sale')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-sale')) {
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$showbtn.' '.$deletebtn;
                    return $btn;
                })

                   /*  ->addColumn('category', function ($product) {
                        $category = null;
                        if (!empty($product->purchase->category)) {
                            $category = $product->purchase->category->categorie;
                        }
                        return $category;
                    })

                    ->addColumn('price', function ($product) {
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
                    }) */
                  /*   ->addColumn('action', function ($row) {
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
                    }) */
                    ->rawColumns(['product','action'])
                    ->make(true);
            }
        }

        return view('admin.sales.index', compact(
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
        $title = 'Créer des ventes';
        $products = Product::get();
        $sales = Sale::whereDate('created_at', '=', Carbon::now())->orderBy('created_at', 'desc')->take(1)->get();
        return view('admin.sales.create', compact(
            'title',
            'sales',
            'products'
        ));
    }

    function fetch(Request $request)
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
        ->where('vendu', "Oui")
        ->get();

      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
        
        /* $now = strtotime(now()); */
        
        /* $expiry_date = strtotime($product->purchase->expiry_date);
        $now = strtotime(now());
        $perime = $expiry_date - $now;
        $perime = floor($perime / 3600 / 24); */

        $product = $row->product;
        $quantity = $row->quantity;
        $id = $row->id;
        $tva = $row->item;
        
        $purchase_id = Purchase::where('product', $product)->first()->id;
        $price = Product::where('purchase_id', $purchase_id)->first()->price;

        /* $cost_price = $row->cost_price; */

       $output .= '
       
       <li data-id="'.$id.'" data-price="'.$price.'" data-quantity="'.$quantity.'" data-tva_app="'.$tva.'"><a href="#">'.$product.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
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
            'product.*'=>'required',
            'nom_client'=>'required|min:2|max:100',
            'telephone_client'=>'nullable|min:9|max:20',
            'quantity'=>'required|min:1'
        ]);

        $user_connect           =   Auth::user();
        $created_by  = strtolower($user_connect->name);
        $updated_by  = strtolower($user_connect->name);

          $code = Sale::get()->last();
        if (isset($code)) {
            $code = Sale::get()->last()->code;
                $code = ++$code;
           
        } else {
            $code = "00001";

        }
        $longueur = strlen($code);

        if ($longueur <= 1) {
            $code   =   strtolower("0000".$code);
        } elseif ($longueur >= 2 && $longueur < 3) {
            $code   =   strtolower("000".$code);
        } elseif ($longueur >= 3 && $longueur < 4) {
            $code   =   strtolower("00".$code);
        } elseif ($longueur >= 4 && $longueur < 4) {
            $code   =   strtolower("0".$code);
        } else {
            $code   =   strtolower($code);
        }
        if (isset($request->modal_vente) && $request->modal_vente == 'oui') {
            /* dd($request->id_producte); */
            /* $sold_product = Product::find($request->product); */
            $purchase = Purchase::find($request->id_producte);    
            $products = Product::where('purchase_id', $purchase->id)->get();

            foreach ($products as $product)

            $product_id = $product->id;
            /**update quantity of
                sold item from
             purchases
            **/
            /* $purchased_item = Purchase::find($sold_product->purchase->id); */

            $new_quantity = ($purchase->quantity) - ($request->quantity);

            $notification = '';

            if (!($new_quantity < 0)) {
                $purchase->update([
                    'quantity'=>$new_quantity,
                ]);

                $product->update([
                    'price'=>$request->price,
                ]);
    
                /**
                 * calcualting item's total price
                **/
                $total_price = ($request->quantity) * ($request->price);
                $total_price = $total_price + ($total_price*$request->tva_app/100);
    
                $sale = Sale::create([
                    'product_id'          =>    $product_id,
                    'code'                =>    $code,
                    'quantity'            =>    $request->quantity,
                    'purchase_quantity'   =>    $purchase->quantity+1,
                    'total_price'         =>    $total_price,
                    'nom_client'          =>    $request->nom_client,
                    'name'                =>    $request->product,
                    'telephone_client'    =>    $request->telephone_client,
                    'item'                =>    $request->tva_app,
                    'created_by'          =>    $created_by,
                    'updated_by'          =>    $updated_by
                ]);
    
                if ($purchase->quantity == 0) {
                    $notification = notify("Le produit a été vendu mais et il n'en reste plus en stock");
                } else {
                    $notification = notify("Le produit a été vendu");
                }
            }
        } else {
            
        $count = count($request->product);
        
        for ($i=0; $i < $count; $i++) {

            $purchase = Purchase::findOrFail($request->id_produit[$i]);

            /* dd(($request->quantity[$i])); */

            /* dd($purchase->quantity); */

            if ($request->quantity[$i] > $purchase->quantity) {
                $this->validate($request, [
                    'quantity'=>'min:'.$purchase->quantity
                ],
                [
                    'quantity.min' => 'Impossible de vendre ce produit car il ne reste en stock que '.$purchase->quantity.' '.$purchase->product
                ]
            );
                
            }

            
            /* for ($i=0; $i < $count; $i++) {            
                $this->validate($request, [
                    'quantite_insuffisante'=>'required'
                ],
                [
                    'quantite_insuffisante.required' => 'La quantité du produit '.$purchase->product.' est insuffisante, il ne reste que '.$purchase->quantity.' en stock'
                ]
            );
            } */
        
        $purchase_id = $purchase->id;

        $sold_product = Product::where('purchase_id', $purchase_id)->get();

        foreach ($sold_product as $sold_product)

        $product_id = $sold_product->id;

        if ($sold_product == null) {
            $notification = notify("Le produit n'est pas encore mis en vente");
            return back()->with($notification);
        }

        /**update quantity of
            sold item from
         purchases
        **/
        

        $purchased_item = Purchase::find($sold_product->purchase_id);
        
        $new_quantity = ($purchased_item->quantity) - ($request->quantity[$i]);
        
        $notification = '';
        if (!($new_quantity < 0)) {
            $purchased_item->update([
                'quantity'=>$new_quantity,
            ]);

            /**
             * calcualting item's total price
            **/
            $total_price = ($request->quantity[$i]) * ($sold_product->price);

            /* dd($total_price); */
            
            /* dd($request->total_price[$i]); */

            $product = Product::find($product_id);

            $product->update([
                'price'=>$request->price[$i],
            ]);

            $sale = Sale::create([
                'product_id'         =>   $product_id,
                'code'               =>   $code,
                'quantity'           =>   $request->quantity[$i],
                'purchase_quantity'  =>   $purchased_item->quantity+1,
                /* 'total_price'        =>   $total_price, */
                'total_price'        =>   $request->total_price[$i],
                'nom_client'         =>   $request->nom_client,
                'name'               =>   $request->product[$i],
                'telephone_client'   =>   $request->telephone_client,
                'created_by'         =>   $created_by,
                'updated_by'         =>   $updated_by
            ]);

            if ($purchased_item->quantity == 0) {
                $notification = notify("Le produit a été vendu mais et il n'en reste plus en stock");
            } else {
                $notification = notify("Le produit a été vendu");
            }
        }
        }
        }

        if ($new_quantity <=0 && $new_quantity !=0) {
            // send notification
            $product = Purchase::where('quantity', '<=', 1)->first();
            event(new PurchaseOutStock($product));
            // end of notification

            //$sale->notify(new SaleAlertNotification($sale, auth()->user()));
            $notification = notify("Le produit est en rupture de stock!!!");
            $this->validate($request, [
                'quantity'=>'required'
            ],
            [
                'quantity.required' => 'La quantité du produit '.$purchase->product.' est insuffisante, il ne reste que '.$purchase->quantity.' en stock'
            ]
        );
        }

              /* $this->validate($request, [
                'quantity'=>'max:'.$purchase->quantity
            ],
            [
                'quantity.max' => 'La quantité du produit '.$purchase->product.' est insuffisante, il ne reste que '.$purchase->quantity.' en stock'
            ]); */
        /* return redirect()->route('sales.index')->with($notification); */

        if (isset($sale) && $new_quantity <=10) {
            $sale->notify(new SaleAlertNotification($sale, auth()->user()));
            //dd($sale);
        }

        return back()->with($notification);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $title = 'edit sale';
        $products = Product::get();
        return view('admin.sales.edit', compact(
            'title',
            'sale',
            'products'
        ));
    }

    public function showFrmNotification(Sale $sale, DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Sale $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $this->validate($request, [
            'product'=>'required',
            'quantity'=>'required|integer|min:1'
        ]);

        $product = Product::find($request->product);

        $new_quantity = $request->quantity;
        $purchase_quantity = $product->purchase->quantity;

        $user_connect           =   Auth::user();
        $updated_by  = strtolower($user_connect->name);

        if ($request->quantity == $sale->quantity) {
            $purchase = Purchase::find($product->purchase->id);
            if (!empty($request->quantity)) {
                $request->quantity = ($purchase->quantity) - ($request->quantity);
            }
            $request->quantity = $sale->quantity;
            $notification = '';
            if (!($request->quantity < 0)) {
                    $total_price = ($request->quantity) * ($product->price);
                $sale->update([
                    'product_id'            =>  $request->product,
                    'quantity'              =>  $request->quantity,
                    'total_price'           =>  $total_price,
                    'nom_client'            =>  $request->nom_client,
                    'updated_by'            =>  $updated_by,
                    'telephone_client'      =>  $request->telephone_client,
                ]);
    
                $notification = notify("".$purchase->product." a été mis à jour");
            }
            return redirect()->route('sales.index')->with($notification);
        } elseif($request->quantity < $sale->quantity) {
            $product = $sale->product;
            $purchase = $product->purchase;   

            $quantity_remise = $sale->quantity - $request->quantity;

            $nouvelle_quantity = $purchase->quantity + $quantity_remise;

            
            $total_price = ($request->quantity) * ($product->price);

            $purchase->update([
                'quantity'=>$nouvelle_quantity,
            ]);

            $sale->update([
                'product_id'            =>  $request->product,
                'quantity'              =>  $request->quantity,
                'total_price'           =>  $total_price,
                'nom_client'            =>  $request->nom_client,
                'updated_by'            =>  $updated_by,
                'telephone_client'      =>  $request->telephone_client,
            ]);
            
            $notification = notify("".$purchase->product." a été mis à jour");

            return redirect()->route('sales.index')->with($notification);

        } else {
            
            $product = $sale->product;
            $purchase = $product->purchase;

            $surplus = $request->quantity - $sale->quantity;
            $surplusss = $request->quantity + $sale->quantity;

            if ($surplus > $purchase->quantity) {
                $this->validate($request, [
                    'quantity'=>'min:'.$surplusss
                ],
                [
                    'quantity.min' => 'Impossible ! il reste en stock : '.$purchase->quantity.' ('.$purchase->product.')'
                ]
            );
                
            } else {            
                $nouvelle_quantity = $purchase->quantity - $surplus;
                
                $purchase = Purchase::find($product->purchase->id);
                
                $total_price = ($request->quantity) * ($product->price);
    
                $purchase->update([
                    'quantity'=>$nouvelle_quantity,
                ]);
    
                $sale->update([
                    'product_id'            =>  $request->product,
                    'quantity'              =>  $request->quantity,
                    'total_price'           =>  $total_price,
                    'nom_client'            =>  $request->nom_client,
                    'updated_by'            =>  $updated_by,
                    'telephone_client'      =>  $request->telephone_client,
                ]);
    
                $notification = notify("".$purchase->product." a été mis à jour");
            }           
            return redirect()->route('sales.index')->with($notification);
            }

    }


    public function facture($id)
    {
        $sale = Sale::find($id);
        $code = $sale->code;


        $title = 'Factures de ventes';

        $sales = Sale::where('code', $code)->get();

        $total = $sales->sum('total_price');
      
        $title =' Facture n° '.$code;

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->setDefaultFont('Courier');
        $options->setIsHtml5ParserEnabled(true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml(view('admin.sales.factures', compact(
            'sales',
            'code',
            'sale',
            'total',
            'title'
        )));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $anne = date('d');
        $anne = $anne.' '.date('m');
        $anne = $anne.' '.date('Y');
        $anne = $anne.' à '.date('H').'h';
        $anne = $anne.' '.date('i').'min';
        $anne = $anne.' '.date('s').'s';

        $name = $sale->nom_client.', facture n° '.$code.' du '.$anne.'.pdf';

        // Output the generated PDF to Browser
        $dompdf->stream($name, ['Attachment' => false]);

    }

    /**
     * Generate Rapports de ventes index
     *
     * @return \Illuminate\Http\Response
     */
    public function reports(Request $request)
    {
        $title = 'Rapports de ventes';
        return view('admin.sales.reports', compact(
            'title'
        ));
    }

    /**
     * Generate sales report form post
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateReport(Request $request)
    {
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $now =  Carbon::now()->format('H:i:s');
        $from_date = date_format(date_create($request->from_date), 'd/m/Y');
        $to_date = date_format(date_create($request->to_date), 'd/m/Y');
        if ($from_date == $to_date) {
            $title = 'Ventes du '.$from_date.' à '.$now;
        } else {
            $title = 'Ventes du'.$from_date.' au '.$to_date.' à '.$now;
        }
        //dd($from_date);
        $sales = Sale::whereBetween(DB::raw('DATE(created_at)'), array($request->from_date, $request->to_date))->get();
        return view('admin.sales.reports', compact(
            'sales',
            'from_date',
            'to_date',
            'title'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $sale = Sale::findOrFail($request->id);
        $product = $sale->product;
        $purchase = $product->purchase;
        
        $new_quantity = $sale->quantity + $purchase->quantity;

        $purchase->update([
            'quantity'=>$new_quantity,
        ]);

        return Sale::findOrFail($request->id)->delete();
    }

    public function tasks(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
            'cost' => 'required',
            'quantite' => 'required',
         ]);

        $count = count($request->task_name);

        for ($i=0; $i < $count; $i++) {
            $task = new Task();
            $task->task_name = $request->task_name[$i];
            $task->cost = $request->cost[$i];
            $task->save();
        }

        $notification = notify("Le produit a été vendu");

        return redirect()->back()->with($notification);
    }
}

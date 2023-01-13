<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\Task;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Events\PurchaseOutStock;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\SaleAlertNotification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;
use Auth;

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
        $title = 'ventes';
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
                        /* return settings('app_currency','$').' '. $sale->total_price; */
                        return settings('app_currency', '').' '. $sale->total_price;
                    })
                    ->addColumn('date', function ($row) {
                        return date_format(date_create($row->created_at), 'd/m/Y à H\h i');
                    })
                   /*  ->addColumn('nom_client',function($row){
                        return settings('app_currency','').' '. $sale->nom_client;
                    })
                    ->addColumn('telephone_client',function($row){
                        return settings('app_currency','').' '. $sale->telephone_client;
                    }) */
                    ->addColumn('action', function ($row) {
                        $editbtn = '<a href="'.route("sales.edit", $row->id).'" class="editbtn"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('sales.destroy', $row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if (!auth()->user()->hasPermissionTo('edit-sale')) {
                            $editbtn = '';
                        }
                        if (!auth()->user()->hasPermissionTo('destroy-sale')) {
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['product','action'])
                    ->make(true);
        }
        $products = Product::get();
        return view('admin.sales.index', compact(
            'title',
            'products',
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

        return view('admin.sales.create', compact(
            'title',
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
        ->get();
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
        
        $now = strtotime(now());
        
        /* $expiry_date = strtotime($product->purchase->expiry_date);
        $now = strtotime(now());
        $perime = $expiry_date - $now;
        $perime = floor($perime / 3600 / 24); */

        $product = $row->product;
        $expiry_date = $row->expiry_date;

       $output .= '
       
       <li><a href="#">'.$product.'</a></li>
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
            'product'=>'required',
            /* 'nom_client'=>'required|min:5|max:255',
            'telephone_client'=>'nullable|min:10|max:20', */
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
            
        $sold_product = Product::find($request->product);

        /**update quantity of
            sold item from
         purchases
        **/
        $purchased_item = Purchase::find($sold_product->purchase->id);
        $new_quantity = ($purchased_item->quantity) - ($request->quantity);
        $notification = '';
        if (!($new_quantity < 0)) {
            $purchased_item->update([
                'quantity'=>$new_quantity,
            ]);

            /**
             * calcualting item's total price
            **/
            $total_price = ($request->quantity) * ($sold_product->price);
            $sale = Sale::create([
                'product_id'          =>    $request->product,
                'code'                =>    $code,
                'quantity'            =>    $request->quantity,
                'purchase_quantity'   =>    $purchased_item->quantity+1,
                'total_price'         =>    $total_price,
                'nom_client'          =>    $request->nom_client,
                'name'                =>    $request->product,
                'telephone_client'    =>    $request->telephone_client,
                'created_by'          =>    $created_by,
                'updated_by'          =>    $updated_by
            ]);

            if ($purchased_item->quantity == 0) {
                $notification = notify("Le produit a été vendu mais et il n'en reste plus en stock");
            } else {
                $notification = notify("Le produit a été vendu");
            }
        }
        } else {
            
        $count = count($request->product);
        
        for ($i=0; $i < $count; $i++) {

        $product_id = Purchase::where('product', $request->product[$i])->first()->id;

        $sold_product = Product::find($product_id);

        if ($sold_product == null) {
            dd("Le produit n'est pas encore mis en vente");
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

            $sale = Sale::create([
                'product_id'         =>   $product_id,
                'code'               =>   $code,
                'quantity'           =>   $request->quantity[$i],
                'purchase_quantity'  =>   $purchased_item->quantity+1,
                'total_price'        =>   $total_price,
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
        }

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
        $sold_product = Product::find($request->product);
        
        $user_connect           =   Auth::user();
        $updated_by  = strtolower($user_connect->name);
        /**
         * update quantity of sold item from purchases
        **/
        $purchased_item = Purchase::find($sold_product->purchase->id);
        if (!empty($request->quantity)) {
            $new_quantity = ($purchased_item->quantity) - ($request->quantity);
        }
        $new_quantity = $sale->quantity;
        $notification = '';
        if (!($new_quantity < 0)) {
            $purchased_item->update([
                'quantity'=>$new_quantity,
            ]);

            /**
             * calcualting item's total price
            **/
            if (!empty($request->quantity)) {
                $total_price = ($request->quantity) * ($sold_product->price);
            }
            $total_price = $sale->total_price;
            $sale->update([
                'product_id'            =>  $request->product,
                'quantity'              =>  $request->quantity,
                'total_price'           =>  $total_price,
                'nom_client'            =>  $request->nom_client,
                'updated_by'            =>  $updated_by,
                'telephone_client'      =>  $request->telephone_client,
            ]);

            $notification = notify("Le produit a été mis à jour");
        }
        if ($new_quantity <=1 && $new_quantity !=0) {
            // send notification
            $product = Purchase::where('quantity', '<=', 1)->first();
            event(new PurchaseOutStock($product));
            // end of notification
            $notification = notify("Le produit est en rupture de stock!!!");
        }
        return redirect()->route('sales.index')->with($notification);
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
            $title = 'Rapports de vente du '.$from_date.' à '.$now;
        } else {
            $title = 'Rapports de vente du '.$from_date.' au '.$to_date.' à '.$now;
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

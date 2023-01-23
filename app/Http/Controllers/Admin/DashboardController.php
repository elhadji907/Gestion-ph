<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Tableau de bord';
        /* $total_purchases = Purchase::where('expiry_date','!=',Carbon::now())->count(); */
        $total_purchases = Purchase::where('expiry_date', '!=', Carbon::now())->count();
        /* $stock_out_purchases = Purchase::where('expiry_date','<=',Carbon::now()->addDays(30))->count(); */
        $total_categories = Category::count();
        $total_suppliers = Supplier::count();
        $total_sales = Sale::count();

        $pieChart = app()->chartjs
                ->name('pieChart')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['Total des achats', 'Total des fournisseurs','Total des ventes'])
                ->datasets([
                    [
                        'backgroundColor' => ['#FF6384', '#36A2EB','#7bb13c'],
                        'hoverBackgroundColor' => ['#FF6384', '#36A2EB','#7bb13c'],
                        'data' => [$total_purchases, $total_suppliers,$total_sales]
                    ]
                ])
                ->options([]);

        $total_expired_products = Purchase::whereDate('expiry_date', '<=', Carbon::now())->count();
        $latest_sales = Sale::whereDate('created_at', '=', Carbon::now())->get();
        $today_sales = Sale::whereDate('created_at', '=', Carbon::now())->sum('total_price');
        $stock_out_purchases = Purchase::where('quantity', '<=', 0)->count();
        //dd($stock_out_purchases);

        $sales = Sale::whereDate('created_at', '=', Carbon::now())->orderBy('created_at', 'desc')->get();

        /* dd($sales); */

        return view('admin.dashboard', compact(
            'title',
            'pieChart',
            'total_expired_products',
            'latest_sales',
            'today_sales',
            'total_categories',
            'sales',
            'stock_out_purchases'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class AutocompleteController extends Controller
{
    //for create controller - php artisan make:controller AutocompleteController

    function index()
    {
     return view('autocomplete');
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
        ->where('vendu', "Non")
        ->get();
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
       $output .= '
       <li data-code="'.$row->cost_price.'"><a href="#">'.$row->product.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
    }

}
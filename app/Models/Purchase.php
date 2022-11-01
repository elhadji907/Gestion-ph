<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Purchase extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'product','category_id','supplier_id',
        'cost_price','quantity','expiry_date',
        'image'
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}

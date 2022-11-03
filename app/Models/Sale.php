<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Sale extends Model
{
    use HasFactory,SoftDeletes,  Notifiable;

    protected $fillable = [
        'product_id','quantity','total_price', 'nom_client', 'telephone_client', 'purchase_quantity', 'item1', 'item2', 'item3'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
}

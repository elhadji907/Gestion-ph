<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','email','phone','company',
        'address','product','comment'
    ];

    public function purchases()
	{
		return $this->hasMany(Purchas::class);
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\product;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'product_id',
        'qty'
    ];
    
    public function product()
{
    return $this->belongsTo(Product::class);
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = ['user_id','product_id','quantity', 'total_price']; // Define fillable fields

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

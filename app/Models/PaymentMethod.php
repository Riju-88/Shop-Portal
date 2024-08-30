<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'pay_method_name',
        'pay_method_description',
    ];

    // public function payments()
    // {
    //     return $this->hasMany(Payment::class);
    // }
}

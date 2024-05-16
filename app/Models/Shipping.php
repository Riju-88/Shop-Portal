<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'first_name', 'last_name', 'address_line_1', 'address_line_2', 'city', 'state', 'postal_code', 'country', 'phone_number', 'payment_status', 'shipping_method_id', 'billing_total'];
    
}

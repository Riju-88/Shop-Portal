<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    // table name
    protected $table = 'shipping';
    protected $fillable = ['user_id', 'first_name', 'last_name', 'address_line_1', 'address_line_2', 'city', 'state', 'postal_code', 'country', 'phone_number', 'shipping_method_id'];
}

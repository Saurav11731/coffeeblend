<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['first_name', 'last_name','state','address','city', 'zip_code', 'phone','email',  'price', 'user_id','status'];
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at'];
}

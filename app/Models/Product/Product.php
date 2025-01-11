<?php

namespace App\Models\Product;
use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name','image', 'price', 'description', 'type'];
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at'];
   
}

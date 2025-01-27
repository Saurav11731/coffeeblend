<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = ['name','review'];
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at'];
}

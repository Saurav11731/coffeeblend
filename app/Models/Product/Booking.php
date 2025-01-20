<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $fillable = ['first_name','last_name','date', 'time','phone', 'message', 'user_id'];
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at'];
}

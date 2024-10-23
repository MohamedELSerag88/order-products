<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image'

    ];

    public $search = ["name"];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public function orders(){
        return $this->belongsToMany(Order::class,'order_items','product_id','order_id');
    }
}

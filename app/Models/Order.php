<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    const PENDING = "Pending";
    const PAID = "Paid";
    const CANCELED = "Canceled";
    protected $fillable = [
        'total',
        'status',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'order_items','order_id',
            'product_id')->withPivot(['quantity',"unit_price"]);
    }

}

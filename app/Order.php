<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}

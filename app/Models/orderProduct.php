<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class orderProduct extends Pivot
{
    
    public $incrementing = true;
    protected $fillable = ['product_name', 'order_id','quantity','total'];
}

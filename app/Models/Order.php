<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','recipient_name','phone','address_text','note',
        'subtotal','shipping_cost','grand_total','status'
    ];

    public function OrderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getGrandTotalFormattedAttribute(){
        return number_format($this->grand_total,0,',','.');
    }

}

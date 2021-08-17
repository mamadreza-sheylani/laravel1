<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";
    protected $guarded = [];

    public function getStatusCheckAttribute($status){
        return $status?'پرداخت شده':'در انتظار پرداخت';
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function transactions(){
        return $this->hasOne(Transaction::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }
}

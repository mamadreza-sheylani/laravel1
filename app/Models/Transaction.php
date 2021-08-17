<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions' ;
    protected $guarded =[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusCheckAttribute($status){
        return $status?'پرداخت شده':'در انتظار پرداخت';
    }

    public function getGatewayNameAttribute($gateway_name){
        switch ($gateway_name) {
            case 'zarinpal':
                $gateway_name = ['color'=>'yellow',"name"=>"زرین پال"];
                break;
            case 'pay':
                $gateway_name = ['color'=>'blue',"name"=>"پی"];
                break;
            default:
                $gateway_name = ['color'=>'green',"name"=>"nothing"];
                break;
        }
        return $gateway_name;
    }
}

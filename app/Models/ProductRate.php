<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRate extends Model
{
    use HasFactory;

    protected $table = 'product_rates' ;
    protected $guarded = [] ;

    public function user(){
        return $this->belongsTo(User::class);
    }
}

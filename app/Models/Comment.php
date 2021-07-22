<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function rate(){
        return $this->hasOne(ProductRate::class , 'user_id' , 'user_id');
        //2nd argu is column in ProductRate table and
        //the 3rd argu is for user_id column in Comment Table
    }

    public function getApprovedAttribute($approved){
        return $approved ? 'تایید شده' : "تایید نشده" ;
    }

}

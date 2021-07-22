<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function store(Request $request , Product $product){

        $validator = Validator::make($request->all(), [
            'text' => 'required|min:5|max:7000',
            'rate' => 'required|digits_between:0,5'
        ]);

        if ($validator->fails()) {
            return redirect()->to(url()->previous() . '#comments')->withErrors($validator);
        }

        if (auth()->check()) {

            try {
                DB::beginTransaction();

                Comment::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'text' => $request->text
                ]);

                if ($product->rates()->where('user_id', auth()->id())->exists()) {
                    $productRate = $product->rates()->where('user_id', auth()->id())->first();
                    $productRate->update([
                        'rate' => $request->rate
                    ]);
                } else {
                    ProductRate::create([
                        'user_id' => auth()->id(),
                        'product_id' => $product->id,
                        'rate' => $request->rate
                    ]);
                }

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
                alert()->error($ex->getMessage() , 'Something Went Wrong With Uploading Comment' )->persistent('ok');
                return redirect()->back();
            }

            alert()->success('Your Comment Will Be displayed After Admin Confirmation' , 'Thanks For Adding A Comment');
            return redirect()->back();
        } else {
            alert()->warning('First Login To Your Account')->persistent('ok');
            return redirect()->back();
        }
    }

    public function comments(){
        $comments = Comment::where('user_id',auth()->user()->id)->where('approved' , 1)->latest()->get();
        return view('home.profile.comments' , compact('comments'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);
        return view("admin.coupons.index" , compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Coupon $coupon)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
            'precentage' => 'required_if:type,=,precentage|max:3',
            'amount' => 'required_if:type,=,amount',
            'max_amount' => 'required_if:type,=,precentage',
            'expire_at' => 'required'

        ]);

        $coupon->create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'amount' => $request->amount,
            'precentage' => $request->precentage,
            'max_precentage_amount' => $request->max_amount,
            'expire_at' => convertShamsiToGregorianDate($request->expire_at),
        ]);

        alert()->success('You Added A New Coupon' , "New Coupon Added");
        return redirect()->route('admin.coupons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show' , compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit' , compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , Coupon $coupon)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
            'precentage' => 'required_if:type,=,precentage|max:3',
            'amount' => 'required_if:type,=,amount',
            'max_amount' => 'required_if:type,=,precentage',
            'expire_at' => 'required'

        ]);

        try {
            DB::beginTransaction();
            $coupon->update([
                'name' => $request->name,
                'code' => $request->code,
                'type' => $request->type,
                'amount' => $request->amount,
                'precentage' => $request->precentage,
                'max_precentage_amount' => $request->max_amount,
                'expire_at' => convertShamsiToGregorianDate($request->expire_at)
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error($ex->getMessage() , 'Something Went Wrong Try Again')->persistent('ok');
            return redirect()->back();
        }
        alert()->success('You Edited Coupon ID '.$coupon->id.' Successfully.' , "Successfully Updated");
        return redirect()->route('admin.coupons.show' , ['coupon'=>$coupon->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

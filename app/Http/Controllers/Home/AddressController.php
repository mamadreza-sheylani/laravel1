<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::all();
        $cities = City::all();
        // return $cities;
        return view('home.profile.address' , compact('cities' , 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validateWithBag('addressStore',[
            'title' => 'required',
            'cellphone' => 'required',
            'address' => 'required',
            'postal_code'=>'required',
            'province_id'=>'required',
            'city_id' => 'required',
        ]);

        Address::create([
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'postal_code'=>$request->postal_code,
            'user_id' => auth()->user()->id,
            'province_id'=>$request->province_id,
            'city_id' => $request->city_id,
            'longitude' =>$request->longitude,
            'latitude' =>$request->latitude
        ]);

        alert()->success('Address added to your profile' , 'Thank you');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function getCities(Request $request){
        $cities = City::where("province_id" , $request->province_id)->get();
        return $cities;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
// use Carbon\Carbon;
use App\Http\Controllers\Admin\ProductImageController;
// use App\Http\Controllers\Admin\ProductVariationController ;
// use App\Models\ProductAttribute;
use App\Models\ProductImage;
// use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('admin.products.index' , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $tags   = Tag::all();
        $categories = Category::where('parent_id' , '!=' , 0)->get(); //gets parent name
        return view('admin.products.create' , compact('brands' , 'tags' , 'categories')) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required' ,
            'brand_id'=> 'required' ,
            'is_active' => 'required' ,
            'tag_ids' => 'required' ,
            'description' => 'required' ,
            'primary_image' => 'required|mimes:jpg,jpeg,png',
            'images' => 'required',
            'images.*' => 'mimes:jpg,jpeg,png',
            'category_id' => 'required',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'required',
            'variation_values' => 'required',
            'variation_values.*.*' => 'required',
            'variation_values.price.*' => 'integer',
            'variation_values.quantity.*' => 'integer',
            'delivery_amount' => 'integer|required' ,
            'delivery_amount_per_product' => 'nullable|integer' ,
        ]);

        try {
            DB::beginTransaction();

            $ProductImageController= new ProductImageController();
            $fileNameImages = $ProductImageController->upload($request->primary_image , $request->images);

            $product = Product::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'is_active' => $request->is_active,
            'description' => $request->description,
            'primary_image' => $fileNameImages['fileNamePrimaryImage'],
            'category_id' => $request->category_id,
            'delivery_amount' => $request->delivery_amount,
            'delivery_amount_per_product' => $request->delivery_amount_per_product,
            ]);

            // attaching images to de relations Table product_image
            foreach($fileNameImages['fileNameImages'] as $fileNameImage){

            ProductImage::create([
                'image' => $fileNameImage ,
                'product_id' => $product->id,
            ]);
            }

            $ProductAttributeController = new ProductAttributeController();
            $ProductAttributeController->store($request->attribute_ids , $product); //Store method in top line controller

            //for variation part
            $category = Category::find($request->category_id); //finding category id
            $ProductVariationController = new ProductVariationController() ; //new object of a controller
            //storing data via store function in that controller
            $ProductVariationController->store($request->variation_values,$category->attribute()->wherePivot('is_variation' , 1)->first()->id ,$product);

            //attaching tags
            $product->tags()->attach($request->tag_ids);


            DB::commit();
        } catch (\Exception $ex) {

            DB::rollBack();
            alert()->error('Problem In Adding Product' ,  $ex->getMessage())->persistent('OK Damn');
            return redirect()->back();
        }

        alert()->success('Thanks For Adding A New Product' , 'Product Added Successfully');
        return redirect()->route('admin.products.create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $images = $product->images;
        $productVariations = $product->variations;
        $productAttributes = $product->attributes()->with('attribute')->get();
        return view('admin.products.show' , compact('product' , 'productAttributes' , 'productVariations' , 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $tags   = Tag::all() ;
        $productVariations = $product->variations;
        $productAttributes = $product->attributes()->with('attribute')->get();
        return view('admin.products.edit'  , compact('product' , 'brands' ,'tags' ,'productVariations' ,'productAttributes' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'is_active' => 'required',
            'tag_ids' => 'required',
            'tag_ids.*' => 'exists:tags,id',
            'description' => 'required',
            'attribute_values' => 'required',
            'variation_values' => 'required',
            'variation_values.*.price' => 'required|integer',
            'variation_values.*.quantity' => 'required|integer',
            'variation_values.*.sale_price' => 'nullable|integer',
            'variation_values.*.date_on_sale_from' => 'nullable|date',
            'variation_values.*.date_on_sale_to' => 'nullable|date',
            'delivery_amount' => 'required|integer',
            'delivery_amount_per_product' => 'nullable|integer',
        ]);

        try {
            DB::beginTransaction();

            $product->update([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product,
            ]);

            $productAttributeController = new ProductAttributeController();
            $productAttributeController->update($request->attribute_values);

            $productVariationController = new ProductVariationController();
            $productVariationController->update($request->variation_values);

            $product->tags()->sync($request->tag_ids);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('Problem In Updating Product', $ex->getMessage())->persistent('Ok :(');
            return redirect()->back();
        }

        alert()->success('Thanks For Updating This Products', 'Product Updated Successfully');
        return redirect()->route('admin.products.index');
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

    public function edit_category(Product $product){

        $categories = Category::where('parent_id' , '!=' , 0)->get();
        return view('admin.products.edit_category' , compact('product' , 'categories'));

    }

    public function update_category(Request $request,Product $product){

        $request->validate([
            'category_id' => 'required',
            'attribute_ids' => 'required',
            'attribute_ids.*' => 'required',
            'variation_values' => 'required',
            'variation_values.*.*' => 'required',
            'variation_values.price.*' => 'integer',
            'variation_values.quantity.*' => 'integer',
        ]);

        try {
            DB::beginTransaction();

            $product->update([
            'category_id' => $request->category_id,
            ]);


            $ProductAttributeController = new ProductAttributeController();
            $ProductAttributeController->change($request->attribute_ids , $product); //Store method in top line controller

            //for variation part
            $category = Category::find($request->category_id); //finding category id
            $ProductVariationController = new ProductVariationController() ; //new object of a controller
            //storing data via store function in that controller
            $ProductVariationController->change($request->variation_values,$category->attribute()->wherePivot('is_variation' , 1)->first()->id ,$product);



            DB::commit();
        } catch (\Exception $ex) {

            DB::rollBack();
            alert()->error('Problem In Adding Product' ,  $ex->getMessage())->persistent('OK Damn');
            return redirect()->back();
        }

        alert()->success(null , 'Category Updated')->persistent('OK');
        return redirect()->route('admin.products.show' , ['product'=>$product->id]);
    }
}


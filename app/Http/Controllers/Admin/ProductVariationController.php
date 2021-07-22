<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
class ProductVariationController extends Controller
{
    public function store($variation , $attributeId , $product){


        $counter = count($variation['value']);


        for($i=0 ; $i<$counter ; $i++) {

            ProductVariation::create([
                'product_id' => $product->id ,
                'attribute_id' => $attributeId,

                'value' => $variation['value'][$i] , //2D data configuration
                'price' => $variation['price'][$i] ,
                'quantity' => $variation['quantity'][$i] ,
                'sku' => $variation['sku'][$i] ,
            ]);
        }
    }

    public function update($variationIds)
    {
        foreach($variationIds as $key => $value){
            $productVariation = ProductVariation::findOrFail($key);

            $productVariation->update([
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'sku' => $value['sku'],
                'sale_price' => $value['sale_price'],
                'date_on_sale_from' => convertShamsiToGregorianDate($value['date_on_sale_from']),
                'date_on_sale_to' => convertShamsiToGregorianDate($value['date_on_sale_to']),
            ]);
        }
    }

    public function change($variation , $attributeId , $product){

        $counter = count($variation['value']);

        ProductVariation::where('product_id',$product->id)->delete();

        for($i=0 ; $i<$counter ; $i++) {

            ProductVariation::create([
                'product_id' => $product->id ,
                'attribute_id' => $attributeId,

                'value' => $variation['value'][$i] , //2D data configuration
                'price' => $variation['price'][$i] ,
                'quantity' => $variation['quantity'][$i] ,
                'sku' => $variation['sku'][$i] ,
            ]);
        }
    }
}

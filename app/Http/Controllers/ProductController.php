<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Product;

class ProductController extends Controller
{
    
    public function create(Request $request) {
    	$validator = Validator::make($request->all(), [
    		'title' => "required",
            "description" => 'required',
            "price" => "required|regex:/^\d*(\.\d{1,2})?$/",
            "inventory" => 'required|integer'
       ]);
        
       if ($validator->fails()) {
            return response()->json([
            	'errors' => $validator->messages()->first()
        	], 403);
       }

        $user = Product::create([
             'title'    => $request->title,
             'description'    => $request->description,
             'price'    => $request->price,
             'inventory'    => $request->inventory
         ]);


        return response()->json(['status' => "ok"], 200);
    }

    public function update(Request $request) {
    	$validator = Validator::make($request->all(), [
           	"id" => 'required|integer',
           	'title' => "required",
            "description" => 'required',
            "price" => "required|regex:/^\d*(\.\d{1,2})?$/",
            "inventory" => 'required|integer'
       ]);
        
       if ($validator->fails()) {
            return response()->json([
            	'errors' => $validator->messages()->first()
        	], 403);
       }

        $user = Product::find($request->id)->update([
             'title'    => $request->title,
             'description'    => $request->description,
             'price'    => $request->price,
             'inventory'    => $request->inventory
         ]);


        return response()->json(['status' => "ok"], 200);
    }

    public function list(Request $request) {
    	$query = Product::select("title", "description", 'price', 'inventory')->where("inventory", ">", 0);
    	if(!empty($request->id))
    		$query->where('id', $request->id);
    	$products = $query->get();
    	$products = json_encode($products);
		return response()->json($products, 200);    	
    }

    public function delete(Request $request) {
    	Product::find($request->id)->delete();

    	return response()->json(['status' => "ok"], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Order;
use \App\Product;
use \App\User;
use Session;

class CartController extends Controller
{
    public function add(Request $request) {    	
    	$product = Product::find($request->id);
        if(!$product) {
            return response()->json(['errors' => "product does not existe"], 201);
        }
        $cart = Session::get('cart');
        $res = number_format($product->price*$request->quantity, 2);
        $item = [
                    "title" => $product->title,
                    "quantity" => $request->quantity,
                    "price" => $res 
                ];
 		if(!$cart) {
            $cart = [
                $request->id => $item
            ];
            Session::put('cart', $cart);
        }
        $cart[$request->id] = $item;
        Session::put('cart', $cart);
        $cart = json_encode(Session::get('cart'));
        return response()->json($cart, 200);
    }

    public function remove(Request $request) {
    	$product = Product::find($request->id);
        if(!$product) {
            return response()->json(['errors' => "product does not existe"], 201);
        }
        $cart = Session::get('cart');
        if(!empty($cart)) {
        	if(!empty($cart[$request->id])) {
        		unset($cart[$request->id]);
        		Session::put('cart', $cart);
        		$cart = json_encode($cart);
		        return response()->json($cart, 200);
        	} else {
        		return response()->json(['errors' => "product does not existe in cart"], 201);
        	}
        } else {
        	return response()->json(['errors' => "cart empty"], 201);
        }
    }

    public function empty(Request $request) {
    	Session::put('cart', []);
    	return response()->json(['msg' => "cart is empty"], 200);
    }
}

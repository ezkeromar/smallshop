<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Order;
use \App\Product;
use \App\User;
use Session;
use Auth;

class OrderController extends Controller
{
    public function list(Request $request) {
    	$query = Order::with(['product']);
    	if(!empty($request->id))
    		$query->where('id', $request->id);
    	$orders = $query->get();
    	$orders = json_encode($orders);
		return response()->json($orders, 200);
    }

    public function changeStatus(Request $request) {
    	$order = Order::find($request->id);
    	switch ($request->status) {
    		case 'fulfilled':
    			$order->status = $request->status;
    			$order->save();
    			break;
    		case 'shipped':
    			$order->status = $request->status;
    			$order->save();
    			break;
    		case 'delivred':
    			$order->status = $request->status;
    			$order->save();
    			break;
    		case 'canceled':
    			$order->status = $request->status;
    			$order->save();
    			break;
    	}
    	dd($order);
    	return response()->json($orders, 200);
    }

    public function payNow(Request $request) {
    	$order = new Order;
    	$order->status = "initial";
    	$order->paid = "1";
    	$order->quantity = $request->quantity;
    	$order->price = 0.00;
    	$order->user_id = Auth::user()->id;
    	$order->save();
    	$products_arr = explode(",", $request->products);
    	$price = 0.00;
    	$quantity = 0;
    	foreach ($products_arr as $key => $value) {
    		$temp_val = explode("|", $value);
    		$product = Product::find($temp_val[0]);
    		$price = number_format($price+($product->price*$temp_val[1]), 2);
    		$quantity += $temp_val[1];
    		$order->product()->attach($temp_val[0]);
    	}
    	$order->price = $price;
    	$order->quantity = $quantity;
    	$order->save();
    	$resultorder = Order::with(['user', 'product'])->find($order->id);
    	$resultorder = json_encode($resultorder);
        return response()->json($resultorder, 200);
        
    }
}

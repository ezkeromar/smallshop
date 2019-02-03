<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

	protected $guarded = ['id'];

	protected $fillable = ['title', 'description', 'price', 'inventory'];
	public $timestamps = true;



    public function order() {
        return $this->belongsToMany('App\Order', 'order_products')
            ->withPivot('product_id', 'order_id');
    }
}

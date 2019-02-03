<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

	protected $guarded = ['id'];
	
	protected $fillable = ['status', 'paid', 'quantity', 'price','user_id'];
	public $timestamps = true;

	public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function product() {
        return $this->belongsToMany('App\Product', 'order_products')
            ->withPivot('order_id', 'product_id');
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Product;
use \App\User;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
    	$email = "ezkeromartest@gmail.com";
    	$password = "123456";
    	$user = User::create([
            'email'    => $email,
            'name'    => 'Omar EZKER',
            'address'    => "Rue Rome Rabat",
            'country'    => 'Morocco',
            'password' => $password,
            'type' => 'customer',
        ]);

    	$token = auth('api')->login($user);

    	$response = $this->call('POST', '/api/product/store', array(
	        "title" => 'produit de test',
        	"description" => "description de produit de test",
        	"price" => 10.20,
        	"inventory" => 10,
        	"token" => $token
	    ));
	    $this->assertEquals(200, $response->getStatusCode());
	    User::where('email', $email)->delete();
    }

    public function testUpdate()
    {
    	$email = "ezkeromartest@gmail.com";
    	$password = "123456";
    	$user = User::create([
            'email'    => $email,
            'name'    => 'Omar EZKER',
            'address'    => "Rue Rome Rabat",
            'country'    => 'Morocco',
            'password' => $password,
            'type' => 'customer',
        ]);

    	$token = auth('api')->login($user);

    	$product = Product::create([
    		"title" => 'produit de test',
        	"description" => "description de produit de test",
        	"price" => 10.20,
        	"inventory" => 10
    	]);

    	$response = $this->call('POST', '/api/product/update', array(
	        "title" => 'produit de test updated',
        	"description" => "description de produit de test",
        	"price" => 10.20,
        	"inventory" => 10,
        	'id' => $product->id,
        	"token" => $token
	    ));
	    $this->assertEquals(200, $response->getStatusCode());
	    Product::find($product->id)->delete();
	    User::where('email', $email)->delete();
    }

    public function testDelete() {
    	$email = "ezkeromartest@gmail.com";
    	$password = "123456";
    	$user = User::create([
            'email'    => $email,
            'name'    => 'Omar EZKER',
            'address'    => "Rue Rome Rabat",
            'country'    => 'Morocco',
            'password' => $password,
            'type' => 'customer'
        ]);

    	$token = auth('api')->login($user);

    	$product = Product::create([
    		"title" => 'produit de test',
        	"description" => "description de produit de test",
        	"price" => 10.20,
        	"inventory" => 10	
    	]);

    	$response = $this->call('GET', '/api/product/delete', array(
	        "id" => $product->id,
	        "token" => $token
        ));
        $this->assertEquals(200, $response->getStatusCode());
	    User::where('email', $email)->delete();
    }

    public function testSelectOne() {
    	$email = "ezkeromartest@gmail.com";
    	$password = "123456";
    	$user = User::create([
            'email'    => $email,
            'name'    => 'Omar EZKER',
            'address'    => "Rue Rome Rabat",
            'country'    => 'Morocco',
            'password' => $password,
            'type' => 'customer'
        ]);

    	$token = auth('api')->login($user);

    	$product = Product::create([
    		"title" => 'produit de test',
        	"description" => "description de produit de test",
        	"price" => 10.20,
        	"inventory" => 10
    	]);

    	$response = $this->call('GET', '/api/product/list', array(
	        "id" => $product->id,
	        "token" => $token
        ));
        $this->assertEquals(200, $response->getStatusCode());
	    Product::find($product->id)->delete();
	    User::where('email', $email)->delete();
    }

    public function testSelectMany() {
    	$email = "ezkeromartest@gmail.com";
    	$password = "123456";
    	$user = User::create([
            'email'    => $email,
            'name'    => 'Omar EZKER',
            'address'    => "Rue Rome Rabat",
            'country'    => 'Morocco',
            'password' => $password,
            'type' => 'customer',
        ]);

    	$token = auth('api')->login($user);

    	$product = Product::create([
    		"title" => 'produit de test',
        	"description" => "description de produit de test",
        	"price" => 10.20,
        	"inventory" => 10
    	]);

    	$response = $this->call('GET', '/api/product/list', array('token' => $token));
        $this->assertEquals(200, $response->getStatusCode());
	    Product::find($product->id)->delete();
	    User::where('email', $email)->delete();
    }
}

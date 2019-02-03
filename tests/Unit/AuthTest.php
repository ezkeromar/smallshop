<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\User;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegister()
    {
    	$email = "ezkeromartest@gmail.com";
    	$response = $this->call('POST', '/api/register', array(
	        "email" => $email,
        	"name" => "Omar EZKER",
        	"address" => "Rue Rome Rabat",
        	"country" => "morocco",
        	"password" =>"123456",
        	"isSeller" => true
	    ));
	    $this->assertEquals(200, $response->getStatusCode());
	    User::where('email', $email)->delete();
    }

    public function testLogin() {
    	$email = "ezkeromartest@gmail.com";
    	$password = "123456";
    	User::create([
            'email'    => $email,
            'name'    => 'Omar EZKER',
            'address'    => "Rue Rome Rabat",
            'country'    => 'Morocco',
            'password' => $password,
            'type' => 'customer',
        ]);

        $response = $this->call('POST', '/api/login', array(
	        "email" => $email,
        	"password" =>$password
	    ));
	    $this->assertEquals(200, $response->getStatusCode());
	    User::where('email', $email)->delete();
    }

    public function testRefreshLogin() {
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

    	$response = $this->call('POST', '/api/refresh', array(
	        "token" => $token
	    ));
    	$this->assertEquals(200, $response->getStatusCode());
	    User::where('email', $email)->delete();
    }

	public function testLogout() {
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

		$response = $this->call('POST', '/api/logout', array('token' => $token));
		
		$this->assertEquals(200, $response->getStatusCode());
		User::where('email', $email)->delete();
	}    
}

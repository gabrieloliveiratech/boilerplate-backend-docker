<?php

namespace Tests\Feature;

use App\Constants\TestsConstants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ProfileTableSeeder;
use Tests\TestCase;


class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test setup
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        (new ProfileTableSeeder())->run();
    }

    /**
     * Test signup.
     *
     * @return void
     */
    public function testSignup()
    {
        $data = [
            'name' => 'User',
            'email' => 'user@boilerplate.com.br',
            'password' => '12345678'
        ];

        $response = $this->post('api/auth/signup', $data)
            ->assertJsonFragment(['name' => $data['name']])
            ->assertStatus(201);
    }

    /**
     * Test login.
     *
     * @return void
     */
    public function testLogin()
    {
        $data = [
            'name' => 'User',
            'email' => 'user@boilerplate.com.br',
            'password' => '12345678'
        ];

        $response = $this->post('api/auth/signup', $data)->assertJsonFragment([
            'email' => 'user@boilerplate.com.br'
        ]);

        $response = $this->post('api/auth/login', $data)->assertJsonFragment([
            'email' => 'user@boilerplate.com.br'
        ]);

        $response->assertStatus(200);
    }


    /**
     * Test login.
     *
     * @return void
     */
    public function testUnauthenticatedException()
    {
        $this->get('api/users')
        ->assertStatus(401)
            ->assertJsonFragment(['error' => 'Por favor, realize o login.']);
    }  
}

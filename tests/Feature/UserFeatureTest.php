<?php

namespace Tests\Feature;

use App\Constants\Constants;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User $user
     */
    public $user;


    /**
     * Test setup
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->state(Constants::PROFILE_USER)->create();
        $this->admin = factory(User::class)->state(Constants::PROFILE_ADMIN)->create();

        $this->userToken = JWTAuth::fromUser($this->user);
        $this->adminToken = JWTAuth::fromUser($this->admin);
    }

    /**
     *
     * @return void
     */
    public function testGetUsers()
    {
        factory(User::class, 10)->state(Constants::PROFILE_USER)->create();

        $response =  $this->withHeaders(['Authorization' => "Bearer " . $this->userToken])->get('api/users')->decodeResponseJson()['data'];

        $this->assertEquals(11, count($response));

        $response =  $this->withHeaders(['Authorization' => "Bearer " . $this->adminToken])->get('api/users')
            ->assertStatus(200)
            ->decodeResponseJson()['data'];

        $this->assertEquals(12, count($response));

        $this->withHeaders(['Authorization' => "Bearer " . $this->userToken])->get('api/users/' . $this->user->id)
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $this->user->name]);

        /**
         * Test pagination
         */
        $this->withHeaders(['Authorization' => "Bearer " . $this->userToken])->get('api/users?page=1&per_page=2')
            ->assertStatus(200)
            ->assertJsonStructure(['meta' => ['pagination' => ['total', 'count', 'per_page', 'current_page', 'total_pages']]]);
    }

    /**
     * Test Filters
     * 
     * @return void
     */
    public function testUsersFilters()
    {
        $userToFilter = factory(User::class)->state(Constants::PROFILE_USER)->create();

        $this->withHeaders(['Authorization' => "Bearer " . $this->userToken])->get('api/users?name=' . $userToFilter->name)
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $userToFilter->name]);

        $this->withHeaders(['Authorization' => "Bearer " . $this->userToken])->get('api/users?username=' . $userToFilter->username)
            ->assertStatus(200)
            ->assertJsonFragment(['username' => $userToFilter->username]);
    }

    /**
     * Test Filters
     * 
     * @return void
     */
    public function testUsersException()
    {
        $this->actingAs($this->user)->get('api/users/' . 3)
            ->assertStatus(404)
            ->assertJsonFragment(['error' => "User not found."]);
    }
}

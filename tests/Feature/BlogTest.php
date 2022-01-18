<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PostTest extends TestCase
{
    protected $faker;

    public function __construct()
    {
        parent::__construct();

        $this->faker = Faker::create();

    }

    /** @test*/
    public function test_promote_console_command_promotes_user()
    {
        $this->artisan('command:role-permission')->assertExitCode(0);
    }

    /** @test*/
    public function test_promote_console_sdfgsdwgf_command_promotes_user()
    {
        $this->artisan('command:import-posts')->assertExitCode(0);
    }

    /** @test*/
    public function test_it_redirects_guest_to_login_when_he_visit_home_page()
    {
        $response = $this->get('/blog');

        $response->assertRedirect('/');
    }

    /** @test*/
    public function test_it_allow_logged_in_user_to_visit_home_page()
    {

        $userName = $this->faker->name;
        $userEmail = $this->faker->email;
        $user = USER::create([
            'name' => $userName,
            'email' => $userEmail,
            'email_verified_at' => now(),
            'password' => Hash::make($this->faker->password),
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        $this->actingAs($user);

        $response = $this->get('/blog');

        $this->assertDatabaseHas('users',
            [
            'name' => $userName,
            'email' => $userEmail
            ]);

        $response->assertOk();
    }

    /** @test*/
    public function test_user_can_view_posts_list()
    {
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertOk();
    }

}

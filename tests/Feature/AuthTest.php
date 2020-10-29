<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLogIn()
    {
        User::factory()->create([
            'username' => 'user',
            'password' => '123'
        ]);

        $this->post('/login', [
            'username' => 'user',
            'password' => '123'
        ])->assertStatus(302);
    }

    public function testUserCanRegister()
    {
        $this->post('/register', [
            'username' => 'test',
            'fullname' => 'testuser',
            'password' => '123',
            'password_confirmation' => '123'
        ]);
        $this->assertEquals('testuser', User::where('username', 'test')->first()->fullname);
    }
}

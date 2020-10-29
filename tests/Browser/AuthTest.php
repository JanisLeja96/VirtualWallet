<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUserCanRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('username', 'TestUser')
                ->type('fullname', 'Test User')
                ->type('password', '123')
                ->type('password_confirmation', '123')
                ->click('@register')
                ->assertPathIs('/wallets');
        });
    }

    public function testAllFieldsRequiredForRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('username', 'TestUser')
                ->type('password', '123')
                ->type('password_confirmation', '123')
                ->click('@register')
                ->assertPathIs('/register');
        });
    }

    public function testUsernameMustBeUnique()
    {
        User::factory()->create(['username' => 'TestUser']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('username', 'TestUser')
                ->type('fullname', 'Test User')
                ->type('password', '123')
                ->type('password_confirmation', '123')
                ->click('@register')
                ->assertPathIs('/register');
        });
    }

}

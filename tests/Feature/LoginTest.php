<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_authenticate_failed()
    {
        $this->visit('/register')
            ->type('abdo', 'username')
            ->type('abdo', 'password')
            ->press('Login')
            ->seePageIs('/register');
    }

    public function test_success_authenticate()
    {
        Session::remove("auth");
        $this->visit('/register')
            ->type('admin', 'username')
            ->type('admin', 'password')
            ->press('Login')
            ->seePageIs('/');
    }



}
